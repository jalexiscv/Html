<?php

namespace App\Modules\Security\Models;

use Higgs\Debug\Toolbar\Collectors\Caches;
use Higgs\Model;

class Security_Users_Fields extends Model
{

    protected $table = "security_users_fields";
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
    protected $cache_time = 18000;
    protected $version = "1.1.1";

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

    /*
     * Recibe el id de un usuario valido y retorna todos los campos asociables como perfil
     * de usuario.
     * @param $user
     * @return array $profile
     */

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

    /**
     * Obtiene la clave de caché para un identificador dado.
     * @param mixed $id Identificador único para el objeto en caché.
     * @return string Clave de caché generada para el identificador.
     **/
    public function get_CacheKey($id)
    {
        $id = is_array($id) ? implode("", $id) : $id;
        $node = APPNODE;
        $table = $this->table;
        $class = urlencode(get_class($this));
        $version = $this->version;
        $key = "{$node}-{$class}-{$table}-{$version}-{$id}";
        return md5($key);
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
        $row = $this->where("user", $user)->where("name", $field)->orderBy("created_at", "DESC")->first();
        if (is_array($row) && !empty($row["value"])) {
            return ($row["value"]);
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
            cache()->delete($this->get_CacheKey("profile-{$id}"));
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
        $profile = $this->get_Profile($user);
        $alias = safe_strtolower($profile["alias"]);
        return ($alias);
    }

    /**
     * Retorna el perfil de un usuario.
     * @param $user
     * @return array|mixed
     */
    public function get_Profile($user): mixed
    {
        helper("App\Helpers\Application_helper");
        $key = $this->get_CacheKey("profile-{$user}");
        $cache = cache($key);
        if (!$this->is_CacheValid($cache)) {
            $ttl = $this->cache_time;
            $firstname = $this->get_Field($user, "firstname");
            $lastname = $this->get_Field($user, "lastname");
            $data = array(
                "user" => $user,
                "name" => "{$firstname} {$lastname}",
                "firstname" => $firstname,
                "lastname" => $lastname,
                "alias" => $this->get_Field($user, "alias"),
                "type" => $this->get_Field($user, "type"),
                "email" => $this->get_Field($user, "email"),
                "avatar" => cdn_url($this->get_Avatar($user)),
                "birthday" => $this->get_Field($user, "birthday"),
                "citizenshipcard" => $this->get_Field($user, "citizenshipcard"),
                "phone" => $this->get_Field($user, "phone"),
                "address" => $this->get_Field($user, "address"),
                "reference" => $this->get_Field($user, "reference"),
                "password" => $this->get_Field($user, "password"),
                "notes" => $this->get_Field($user, "notes"),
                "expedition_date" => $this->get_Field($user, "expedition_date"),
                "expedition_place" => $this->get_Field($user, "expedition_place"),
                "moodle-username" => $this->get_Field($user, "moodle-username"),
                "moodle-password" => $this->get_Field($user, "moodle-password"),
                "sie-registration" => $this->get_Field($user, "sie-registration"),
                "created_at" => $this->get_Field($user, "created_at"),
                "updated_at" => $this->get_Field($user, "updated_at"),
                "deleted_at" => $this->get_Field($user, "deleted_at")

            );
            $cache = array('value' => $data, 'retrieved' => true, "expire" => time() + $ttl);
            Caches::addMessage('Create', "{$key} : Perfil del usuario {$user}", $ttl);
            cache()->save($key, $cache, $ttl);
        }
        $remaining = $cache['expire'] - time();
        Caches::addMessage('Read', "{$key} : Perfil del usuario {$user}", $remaining);
        return ($cache['value']);
    }

    /**
     * Método is_CacheValid
     * Este método verifica si los datos recuperados de la caché son válidos.
     * @param mixed $cache - Los datos recuperados de la caché.
     * @return bool - Devuelve true si los datos de la caché son válidos, false en caso contrario.
     */
    private function is_CacheValid(mixed $cache): bool
    {
        return is_array($cache) && array_key_exists('retrieved', $cache) && $cache['retrieved'] === true;
    }

    public function get_Avatar($user)
    {
        $mattachments = model('App\Modules\Storage\Models\Storage_Attachments');
        $avatar = $mattachments->get_Avatar($user);
        return ($avatar);
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
     * Retorna el nombre completo de un usuario.
     * @param $user
     * @return string
     */

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

    public function update($id = null, $data = null): bool
    {
        $result = parent::update($id, $data);
        if ($result === true) {
            cache()->delete($this->get_CacheKey("profile-{$id}"));
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
            cache()->save($cache_key, $data, $this->cache_time * 1000);
        }
        return ($data);
    }

}

?>