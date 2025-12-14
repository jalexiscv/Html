<?php

namespace App\Modules\Settings\Models;

use Higgs\Model;

class Settings_Users_Fields extends Model
{

    protected $table = "settings_users_fields";
    protected $primaryKey = "field";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "field",
        "user",
        "name",
        "value",
        "author",
        "created_at",
        "updated_at",
        "deleted_at"
    ];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "authentication";
    protected $cache_time = 60;
    protected $version = "1.0.0";

    /*
     * Recibe el id de un usuario valido y genera un token de unico acceso correspondiente con
     * la funcion reset la cual es utilizada por los usuarios para recuperar acceso  a la cuenta
     * cuando el usuario solicita este servicio desde la UI.
     */
    function get_ResetToken($user)
    {
        $token = md5(pk());
        $this->insert(array(
            "field" => pk(),
            "user" => $user,
            "name" => "reset-token",
            "value" => $token,
            "author" => "SYSTEM"
        ));
        return ($token);
    }

    public function insert($data = null, bool $returnID = true)
    {
        $result = parent::insert($data, $returnID);
        if ($result === true || $returnID && is_numeric($result)) {
            $cache_key = $this->get_CacheKey($this->db->insertID());
            $data = parent::find($this->db->insertID());
            cache()->save($cache_key, $data, $this->cache_time);
        }

        return $result;
    }

    protected function get_CacheKey($id)
    {
        $md5 = md5(APPNODE . '_' . $this->table . '_' . str_replace('\\', '_', get_class($this)) . '_' . $id . $this->version);
        return ($md5);
    }

    public function find($id = null)
    {
        $cache_key = $this->get_CacheKey($id);
        if (!$data = cache($cache_key)) {
            $data = parent::find($id);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($data);
    }

    public function insert_Transactioned($user, $fields): void
    {
        if (is_array($fields)) {
            $this->db->transStart();
            foreach ($fields as $key => $value) {
                $this->insert(array("field" => pk(), "user" => $user, "name" => $key, "value" => $value));
            }
            $this->db->transComplete();
            if ($this->db->transStatus() === false) {
                throw new Exception("Algo salió mal, puedes tomar medidas adecuadas");
            }
        } else {
            throw new Exception("Se esperaba un arreglo!");
        }
    }

    /**
     * Retorna el email de un usuario especifico
     * @param $user
     * @return bool|string
     */
    public function get_Email($user)
    {
        return ($this->get_Field($user, "email"));
    }

    /**
     * Retorna el valor almacenado para el campo de un usuario
     * - Cacheado
     * @param type $id codigo primario del registro a consultar
     * @param type $author codigo del usuario del cual se pretende establecer la autoria
     * @return boolean falso o verdadero segun sea el caso
     */
    public function get_Field($user, $field): string
    {
        if (!empty($user) && !empty($field)) {
            if ($user != "anonymous") {
                $cache_key = $this->get_CacheKey("{$user}{$field}");
                if (!$data = cache($cache_key)) {
                    $row = $this->where("user", $user)->where("name", $field)->orderBy("created_at", "DESC")->first();
                    $data = (is_array($row) && isset($row["value"])) ? $row["value"] : "";
                    cache()->save($cache_key, $data, $this->cache_time);
                }
                return ($data);
            }
        }
        return (false);
    }

    /**
     * Elimina todos los campos asociados con un usuario.
     * @param $user
     * @return string
     */
    public function delete_AllByUser($user): string
    {
        $delete = $this->where("user", $user)->delete();
        return ($delete);
    }

    public function delete($id = null, $purge = false)
    {
        $result = parent::delete($id, $purge);
        if ($result === true) {
            cache()->delete($this->get_CacheKey($id));
        }
        return ($result);
    }

    /**
     * Obtiene un usuario por su dirección de correo electrónico.
     * @param string $email Dirección de correo electrónico del usuario.
     * @return mixed Devuelve el usuario si se encuentra en la base de datos; de lo contrario, devuelve false.
     */
    public function get_UserByEmail($email)
    {
        $row = $this->where("name", "email")->where("value", $email)->first();

        if (is_array($row) && !empty($row["user"])) {
            return ($row["user"]);
        }

        return (false);
    }

    /**
     * Retorna el código de usuario asociado a un alias especifico.
     * @param type $phone
     * @return type
     */
    public function get_UserByAlias($alias)
    {
        $row = $this->where("name", "alias")->where("value", $alias)->first();
        return (@$row["user"]);
    }

    /**
     * Retorna el alias de un codigo de usuario.
     * @param type $phone
     * @return type
     */
    public function get_AliasByUser($user): string
    {
        $alias = safe_strtolower($this->get_Field($user, "alias"));
        return ($alias);
    }

    /**
     * Retorna el código de usuario asociado a un codigo de acceso de recuperación
     * @param type $email
     * @return type
     */
    public function get_UserByResetToken($token)
    {
        $row = $this
            ->where("value", $token)
            ->first();
        if (is_array($row) && !empty($row["user"])) {
            return ($row["user"]);
        } else {
            return (false);
        }
    }

    /**
     * Retorna el código de usuario asociado a un codigo de acceso de recuperación
     * @param type $email
     * @return type
     */
    public function get_UserByAccessCode($accesscode)
    {
        $row = $this->where("name", "accesscode")->where("value", $accesscode)->first();
        if (is_array($row) && !empty($row["user"])) {
            return ($row["user"]);
        } else {
            return (false);
        }
    }

    /**
     * Retorna el código de usuario asociado a un token de correo electronico
     * @param type $email
     * @return type
     */
    public function get_UserByTokenEmail($tokenemail)
    {
        $row = $this->where("name", "token_email")->where("value", $tokenemail)->first();
        return (@$row["user"]);
    }

    /**
     * Retorna el código de usuario asociado a un codigo de correo electronico
     * @param type $email
     * @return type
     */
    public function get_UserByEmailCode($code)
    {
        $row = $this->where("name", "email_code")->where("value", $code)->first();
        return (@$row["user"]);
    }

    /**
     * Retorna el código de usuario asociado a un numero telefonico
     * @param type $phone
     * @return type
     */
    public function get_UserByPhone($phone)
    {
        $row = $this->where("name", "phone")->where("value", $phone)->first();
        return (@$row["user"]);
    }

    /**
     * Retorna falso o verdadero si el usuario activo ne la sesión es el
     * autor del regsitro que se desea acceder, editar o eliminar.
     * @param type $id codigo primario del registro a consultar
     * @param type $author codigo del usuario del cual se pretende establecer la autoria
     * @return boolean falso o verdadero segun sea el caso
     */
    public function get_Authority($id, $author)
    {
        $row = $this->where("field", $id)->first();
        if ($row["author"] == $author) {
            return (true);
        } else {
            return (false);
        }
    }

    /**
     * Retorna la informacion de un usuario de un cache almacenado
     * o genera uno nuevo so no lo hay.
     * - Cacheado
     **/
    public function get_User($user)
    {
        $cache_key = $this->get_CacheKey($user);
        if (!$data = cache($cache_key)) {
            $data = array(
                "user" => $user,
                "fullname" => $this->get_FullName($user),
                "alias" => $this->get_Field($user, "alias"),
                "email" => $this->get_Field($user, "email"),
            );
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($data);
    }

    /**
     * Retorna el nombre completo de un usuario.
     * @param $user
     * @return string
     */

    public function get_FullName($user): string
    {
        $firstname = urldecode($this->get_Field($user, 'firstname'));
        $lastname = urldecode($this->get_Field($user, 'lastname'));
        return ("{$firstname} {$lastname}");
    }

    public function get_Profile($user)
    {
        $cache_key = $this->get_CacheKey($user);
        if (!$data = cache($cache_key)) {
            $data = array(
                "user" => $user,
                "name" => $this->get_FullName($user),
                "alias" => $this->get_Field($user, "alias"),
                "email" => $this->get_Field($user, "email"),
                "avatar" => $this->get_Avatar($user),
            );
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($data);
    }

    public function get_Avatar($user)
    {
        $avatar = "/themes/bs5/img/avatars/avatar-neutral.png";
        $mattachments = model('App\Modules\Storage\Models\Storage_Attachments');
        $attachment = $mattachments
            ->where("object", $user)
            ->where("reference", "AVATAR")
            ->orderBy("created_at", "DESC")
            ->first();
        if (isset($attachment["file"]) && !empty($attachment["file"])) {
            $avatar = $attachment["file"];
        }
        return ($avatar);
    }

    public function update($id = null, $data = null): bool
    {
        $result = parent::update($id, $data);

        if ($result === true) {
            $cache_key = $this->get_CacheKey($id);
            $data = parent::find($id);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($result);
    }

    /**
     * Este método verifica si la tabla especificada existe en la base de datos utilizando la función tableExists()
     * del objeto db de CodeIgniter. Además, utiliza la caché para almacenar el resultado de la verificación para mejorar
     * el rendimiento y evitar la sobrecarga de la base de datos. La clave de caché se crea utilizando el método
     * get_CacheKey(), que se supone que retorna una clave única para la tabla especificada. El tiempo de duración de
     * la caché se establece en el atributo $cache_time.
     * @param $tableName
     * @return \Higgs\Cache\CacheInterface|bool|mixed
     */
    private function tableExists($tableName)
    {
        $cache_key = '_table_exist_' . APPNODE . '_' . $this->table;
        if (!$data = cache($cache_key)) {
            $data = $this->db->tableExists($tableName);
            cache()->save($cache_key, $data, $this->cache_time * 10);
        }
        return ($data);
    }

}

?>