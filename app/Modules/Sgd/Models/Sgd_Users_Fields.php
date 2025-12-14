<?php

namespace App\Modules\Sgd\Models;

use App\Models\CachedModel;
use Config\Services;

/**
 * Ej: $model = model('App\Modules\Security\Models\Security_Users_Fields');
 * @Copilot Siempre que en el código se cree una variable llamada $mfields, esta deberá ser igualada a model("App\Modules\Sie\Models\Sie_Users_Fields");
 * @Instruction $mfields = model("App\Modules\Sgd\Models\Sgd_Users_Fields");
 * @method where(mixed $primaryKey, string $id) : \Higgs\Database\BaseBuilder
 * @method groupStart() : \Higgs\Database\BaseBuilder
 */
class Sgd_Users_Fields extends CachedModel
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
        "deleted_at",
    ];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "authentication";//default
    protected $version = '1.0.3';
    protected $cache_time = 60;
    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        $this->exec_Migrate();
    }


    /**
     * Ejecuta las migraciones para el módulo actual.
     * @return void
     */
    private function exec_Migrate(): void
    {
        $migrations = Services::migrations();
        try {
            $migrations->setNamespace('App\Modules\Security');// Set the namespace for the current module
            $migrations->latest();// Run the migrations for the current module
            $all = $migrations->findMigrations();// Find all migrations for the current module
        } catch (Throwable $e) {
            echo($e->getMessage());
        }
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
     * Obtiene una lista de registros con un rango especificado y opcionalmente filtrados por un término de búsqueda.
     * con opciones de filtrado y paginación.
     * @param int $limit El número máximo de registros a obtener por página.
     * @param int $offset El número de registros a omitir antes de comenzar a seleccionar.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return array|false        Un arreglo de registros combinados o false si no se encuentran registros.
     */
    public function get_List(int $limit, int $offset, string $search = ""): array|false
    {
        $result = $this
            ->groupStart()
            ->like("field", "%{$search}%")
            ->orLike("user", "%{$search}%")
            ->orLike("name", "%{$search}%")
            ->orLike("value", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->groupEnd()
            ->orderBy("created_at", "DESC")
            ->findAll($limit, $offset);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Retorna el listado de elementos existentes de forma que se pueda cargar un field tipo select.
     * Ejemplo de uso:
     * $model = model("App\Modules\Sie\Models\Sie_Modules");
     * $list = $model->get_SelectData();
     * $f->get_FieldSelect("list", array("selected" => $r["list"], "data" => $list, "proportion" => "col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"));
     */
    public function get_SelectData()
    {
        $result = $this->select("`{$this->primaryKey}` AS `value`,`name` AS `label`")->findAll();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     * Obtiene la clave de caché para un identificador dado.
     * @param $product
     * @return array|false
     */
    public function get_Field($user, $field): false|string
    {
        $row = $this->where("user", $user)->where("name", $field)->orderBy("created_at", "DESC")->first();
        if (is_array($row) && !empty($row["value"])) {
            return ($row["value"]);
        }
        return (false);
    }


    public function get_Avatar($user)
    {
        $mattachments = model('App\Modules\Storage\Models\Storage_Attachments');
        $avatar = $mattachments->get_Avatar($user);
        return ($avatar);
    }


    /**
     * Retorna el valor almacenado para el campo de un usuario
     * - Cacheado
     * @param type $id codigo primario del registro a consultar
     * @param type $author codigo del usuario del cual se pretende establecer la autoria
     * @return boolean falso o verdadero segun sea el caso
     */
    public function get_UncachedField($user, $field): string
    {
        $row = $this->where("user", $user)->where("name", $field)->orderBy("created_at", "DESC")->first();
        if (is_array($row) && !empty($row["value"])) {
            return ($row["value"]);
        }
        return (false);
    }



    public function get_CachedFullName($user){
        $key=md5($user);
        $result=$this->get_Cached($key);
        if (empty($result)) {
            $result = $this->get_FullName($user);
            $this->save_Cache($key,$result);
        }
        return $result;
    }

    public function get_FullName($user)
    {
        $firstname = $this->get_Field($user, "firstname");
        $lastname = $this->get_Field($user, "lastname");
        if ($firstname && $lastname) {
            return ($firstname . " " . $lastname);
        } else {
            return ("");
        }
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
     * Obtiene un usuario por su número de documento de identificacion
     * @param $citizenshipcard
     * @return false|mixed
     */
    public function get_UserByCitizenshipcard($citizenshipcard)
    {
        $row = $this->where("name", "citizenshipcard")->where("value", $citizenshipcard)->first();
        if (is_array($row) && !empty($row["user"])) {
            return ($row["user"]);
        }
        return (false);
    }


    public function get_CachedProfile($user) {
        if (empty($user)) {
            return [];
        }

        // Create cache instance
        $cache = \Config\Services::cache();
        $key = md5("cached-profile-" . $user);

        // Try to get from cache
        $result = $cache->get($key);

        if ($result === null) {
            // Cache miss - retrieve and store profile
            //echo("Cache miss for user {$user}<br>");
            $result = $this->get_Profile($user);

            if (!empty($result)) {
                // Store in cache with the configured timeout
                $cache->save($key, $result, $this->cache_time);
            }
        }

        return $result;
    }


    /**
     * Retorna el perfil de un usuario.
     * @param $user
     * @return array|mixed
     */
    public function get_Profile($user): mixed
    {
        $firstname = $this->get_Field($user, "firstname");
        $lastname = $this->get_Field($user, "lastname");
        $avatar = "/assets/images/avatars/avatar.png";
        if (!empty($user)) {
            $avatar = $this->get_Avatar(@$user);
        }

        $data = array(
            "user" => $user,
            "name" => "{$firstname} {$lastname}",
            "firstname" => $firstname,
            "lastname" => $lastname,
            "alias" => $this->get_Field($user, "alias"),
            "type" => $this->get_Field($user, "type"),
            "email" => $this->get_Field($user, "email"),
            "avatar" => cdn_url($avatar),
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
            "created_at" => $this->get_Field($user, "created_at"),
            "updated_at" => $this->get_Field($user, "updated_at"),
            "deleted_at" => $this->get_Field($user, "deleted_at")

        );

        return ($data);
    }
}

?>