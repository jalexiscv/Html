<?php

namespace App\Modules\Security\Models;

use App\Models\CachedModel;
use Config\Services;

/**
 * Ej: $model = model('App\Modules\Security\Models\Security_Users');
 * @method insert(array $data, bool $returnID = true, bool $protect = true) : int|string
 * @method update(string $id, array $data) : bool
 * @method delete(string $id, bool $purge = false) : bool
 * @method get_CachedFirst(array $conditions): array|object|null
 * @method get_CachedSearch(array $conditions = [], int $limit = 10, int $offset = 0, string $orderBy = '', int $page = 1): array
 */
class Security_Users extends CachedModel
{
    protected $table = "security_users";
    protected $primaryKey = "user";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "user",
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
    protected $version = '1.0.1';
    protected $cache_time = 60;

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        //$this->exec_Migrate();
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
     * Obtiene una lista de usuarios combinados con sus campos personalizados (alias, firstname, lastname, phone, address, email, avatar)
     * con opciones de filtrado y paginación. Los campos personalizados se obtienen de la tabla security_users_fields.
     * @param int $limit El número de registros a obtener.
     * @param int $offset El número de registros a saltar.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return false|array    El número total de registros.
     */
    public function get_List(int $limit, int $offset, string $search = ""): false|array
    {
        $builder = $this->db->table($this->table . ' AS su');
        $customFields = ['alias', 'firstname', 'lastname', 'phone', 'address', 'email', 'avatar'];
        foreach ($customFields as $field) {
            $subQuery = $this->db->table('security_users_fields')
                ->select('value')
                ->where('user', 'su.user', false)
                ->where('name', $field)
                ->orderBy('created_at', 'DESC')
                ->limit(1)
                ->getCompiledSelect();
            $builder->select("($subQuery) AS $field", false);
        }
        $builder->select('su.user, su.deleted_at');
        $builder->where('su.deleted_at', null);
        if ($search !== "") {
            $builder->groupStart();
            $builder->like('su.user', $search);
            foreach ($customFields as $field) {
                $builder->orLike("(SELECT rsf_inner.value
                    FROM security_users_fields rsf_inner
                    WHERE rsf_inner.user = su.user AND rsf_inner.name = '$field'
                    ORDER BY rsf_inner.created_at DESC
                    LIMIT 1)", $search);
            }
            $builder->groupEnd();
        }
        $builder->limit($limit, $offset);
        $builder->groupBy('su.user');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function get_ListByType(int $limit, int $offset, string $type, string $search = "")
    {
        // Usar el builder desde el modelo actual
        $builder = $this->db->table($this->table . ' AS su');

        // Primera parte: Crear la subconsulta para LatestFields
        $subquery = $this->db->table('security_users_fields')
            ->select("
        user,
        name,
        value,
        created_at,
        ROW_NUMBER() OVER (PARTITION BY user, name ORDER BY created_at DESC) as rn
    ", false)
            ->where('deleted_at IS NULL')
            ->whereIn('name', ['alias', 'type', 'firstname', 'lastname','gender','marital_status', 'phone', 'address', 'email','email_personal','institutional_address','participant_teacher','participant_executive','participant_authority','birthday','birth_country','birth_region','birth_city','avatar', 'citizenshipcard','expedition_date']);

        // Convertir la subconsulta en una cadena SQL
        $latestFieldsSQL = $subquery->getCompiledSelect();

        // Construir la consulta principal con todos los campos solicitados
        $builder->select(" 
        su.user,
        MAX(CASE WHEN lf.name = 'alias' AND lf.rn = 1 THEN lf.value END) as alias,
        MAX(CASE WHEN lf.name = 'type' AND lf.rn = 1 THEN lf.value END) as type,
        MAX(CASE WHEN lf.name = 'firstname' AND lf.rn = 1 THEN lf.value END) as firstname,
        MAX(CASE WHEN lf.name = 'lastname' AND lf.rn = 1 THEN lf.value END) as lastname,
        MAX(CASE WHEN lf.name = 'gender' AND lf.rn = 1 THEN lf.value END) as gender,
        MAX(CASE WHEN lf.name = 'marital_status' AND lf.rn = 1 THEN lf.value END) as marital_status,
        MAX(CASE WHEN lf.name = 'phone' AND lf.rn = 1 THEN lf.value END) as phone,
        MAX(CASE WHEN lf.name = 'address' AND lf.rn = 1 THEN lf.value END) as address,
        MAX(CASE WHEN lf.name = 'participant_teacher' AND lf.rn = 1 THEN lf.value END) as participant_teacher,
        MAX(CASE WHEN lf.name = 'participant_executive' AND lf.rn = 1 THEN lf.value END) as participant_executive,
        MAX(CASE WHEN lf.name = 'participant_authority' AND lf.rn = 1 THEN lf.value END) as participant_authority,
        MAX(CASE WHEN lf.name = 'avatar' AND lf.rn = 1 THEN lf.value END) as avatar,
        MAX(CASE WHEN lf.name = 'email' AND lf.rn = 1 THEN lf.value END) as email,
        MAX(CASE WHEN lf.name = 'email_personal' AND lf.rn = 1 THEN lf.value END) as email_personal,
        MAX(CASE WHEN lf.name = 'institutional_address' AND lf.rn = 1 THEN lf.value END) as institutional_address,
        MAX(CASE WHEN lf.name = 'birthday' AND lf.rn = 1 THEN lf.value END) as birthday,
        MAX(CASE WHEN lf.name = 'birth_country' AND lf.rn = 1 THEN lf.value END) as birth_country,
        MAX(CASE WHEN lf.name = 'birth_region' AND lf.rn = 1 THEN lf.value END) as birth_region,
        MAX(CASE WHEN lf.name = 'birth_city' AND lf.rn = 1 THEN lf.value END) as birth_city,
        MAX(CASE WHEN lf.name = 'citizenshipcard' AND lf.rn = 1 THEN lf.value END) as citizenshipcard,
        MAX(CASE WHEN lf.name = 'expedition_date' AND lf.rn = 1 THEN lf.value END) as expedition_date,
        MAX(CASE WHEN lf.name = 'avatar' AND lf.rn = 1 THEN lf.value END) as avatar
    ", false)
            ->join("($latestFieldsSQL) lf", 'su.user = lf.user', 'inner')
            ->where('su.deleted_at IS NULL');

        // Modificación en la cláusula EXISTS
        $exists_condition = "EXISTS (
        SELECT 1 
        FROM ($latestFieldsSQL) lf_type 
        WHERE lf_type.user = su.user 
        AND lf_type.name = 'type' 
        AND lf_type.value = '{$this->db->escapeString($type)}'
        AND lf_type.rn = 1
    )";

        $builder->where($exists_condition);

        // Agregar búsqueda si se proporciona
        if (!empty($search)) {
            $search = $this->db->escapeLikeString($search);
            $having_condition = "
            MAX(CASE WHEN lf.name = 'firstname' AND lf.rn = 1 THEN lf.value END) LIKE '%{$search}%' OR 
            MAX(CASE WHEN lf.name = 'lastname' AND lf.rn = 1 THEN lf.value END) LIKE '%{$search}%' OR 
            MAX(CASE WHEN lf.name = 'email' AND lf.rn = 1 THEN lf.value END) LIKE '%{$search}%' OR
            MAX(CASE WHEN lf.name = 'phone' AND lf.rn = 1 THEN lf.value END) LIKE '%{$search}%' OR
            MAX(CASE WHEN lf.name = 'alias' AND lf.rn = 1 THEN lf.value END) LIKE '%{$search}%' OR
            MAX(CASE WHEN lf.name = 'citizenshipcard' AND lf.rn = 1 THEN lf.value END) LIKE '%{$search}%' OR
            su.user LIKE '%{$search}%'
        ";
            $builder->having($having_condition, null, false);
        }

        // Ordenar resultados
        $builder->groupBy('su.user')
            ->orderBy('firstname', 'ASC')
            ->orderBy('lastname', 'ASC');

        // Aplicar límite y offset para paginación
        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Método adicional para obtener el total de registros (útil para paginación)
     * @param string $type
     * @param string $search
     * @return int
     **/
    public function get_ListByTypeCount(string $type, string $search = "")
    {
        $builder = $this->db->table($this->table . ' AS su');

        $subquery = $this->db->table('security_users_fields')
            ->select("
            user,
            name,
            value,
            created_at,
            ROW_NUMBER() OVER (PARTITION BY user, name ORDER BY created_at DESC) as rn
        ", false)
            ->where('deleted_at IS NULL')
            ->whereIn('name', ['alias', 'type', 'firstname', 'lastname', 'phone', 'address', 'email', 'avatar', 'citizenshipcard']);

        $latestFieldsSQL = $subquery->getCompiledSelect();

        $builder->select("su.user", false)
            ->join("($latestFieldsSQL) lf", 'su.user = lf.user', 'inner')
            ->where('su.deleted_at IS NULL')
            ->where("EXISTS (
            SELECT 1 
            FROM ($latestFieldsSQL) lf_type 
            WHERE lf_type.user = su.user 
            AND lf_type.name = 'type' 
            AND lf_type.value = ?
            AND lf_type.rn = 1
        )", [$type], false)
            ->groupBy('su.user');

        if (!empty($search)) {
            $builder->having("(
            MAX(CASE WHEN lf.name = 'firstname' AND lf.rn = 1 THEN lf.value END) LIKE ? OR 
            MAX(CASE WHEN lf.name = 'lastname' AND lf.rn = 1 THEN lf.value END) LIKE ? OR 
            su.user LIKE ?
        )", ["%$search%", "%$search%", "%$search%"]);
        }

        return $builder->countAllResults();
    }


    /**
     * Returns the cached total count of users by type with optional search filter
     * @param string $type Type of users to count
     * @param string $search Optional search term to filter results
     * @return int Total count of matching users
     */
    public function getCachedTotalByType(string $type, string $search = ""): int
    {
        $conditions = ['type' => $type, 'search' => $search];
        $key = $this->getSearchCacheKey($conditions, 0, 0, '', 1);
        $cache = $this->readCache($key);
        if ($cache === null) {
            $cache = $this->get_TotalByType($type, $search);
            $this->saveCache($key, $cache);
        }
        return ($cache);
    }


    /**
     * Obtiene el número total de registros combinados de con opciones de filtrado.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return int    El número total de registros.
     */
    public function get_TotalByType($type, $search = "")
    {
        if (empty($search)) {
            $search = $type;
        }
        $query = $this->db->table('security_users su');
        $query->select('su.user');
        $query->select("MAX(CASE WHEN rsf.name = 'alias' THEN rsf.value END) AS alias");
        $query->select("MAX(CASE WHEN rsf.name = 'firstname' THEN rsf.value END) AS firstname");
        $query->select("MAX(CASE WHEN rsf.name = 'lastname' THEN rsf.value END) AS lastname");
        $query->select("MAX(CASE WHEN rsf.name = 'phone' THEN rsf.value END) AS phone");
        $query->select("MAX(CASE WHEN rsf.name = 'address' THEN rsf.value END) AS address");
        $query->select("MAX(CASE WHEN rsf.name = 'email' THEN rsf.value END) AS email");
        $query->join('security_users_fields rsf', 'su.user = rsf.user', 'inner');
        $query->where('su.deleted_at', null);
        if (!empty($search)) {
            $query->groupStart(); // Empezar grupo para condiciones WHERE
            $query->like('su.user', $search);
            $query->orLike('rsf.value', $search);
            $query->groupEnd(); // Finalizar grupo de condiciones WHERE
        }
        $query->groupBy('su.user');
        $result = $query->countAllResults();
        return $result;
    }

    /**
     * Obtiene el número total de registros combinados de con opciones de filtrado.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return int    El número total de registros.
     */
    public function get_Total($search = "")
    {
        $query = $this->db->table('security_users su');
        $query->select('su.user');
        $query->select("MAX(CASE WHEN rsf.name = 'alias' THEN rsf.value END) AS alias");
        $query->select("MAX(CASE WHEN rsf.name = 'firstname' THEN rsf.value END) AS firstname");
        $query->select("MAX(CASE WHEN rsf.name = 'lastname' THEN rsf.value END) AS lastname");
        $query->select("MAX(CASE WHEN rsf.name = 'phone' THEN rsf.value END) AS phone");
        $query->select("MAX(CASE WHEN rsf.name = 'address' THEN rsf.value END) AS address");
        $query->select("MAX(CASE WHEN rsf.name = 'email' THEN rsf.value END) AS email");
        $query->join('security_users_fields rsf', 'su.user = rsf.user', 'inner');
        $query->where('su.deleted_at', null);
        if (!empty($search)) {
            $query->groupStart(); // Empezar grupo para condiciones WHERE
            $query->like('su.user', $search);
            $query->orLike('rsf.value', $search);
            $query->groupEnd(); // Finalizar grupo de condiciones WHERE
        }
        $query->groupBy('su.user');
        $result = $query->countAllResults();
        return $result;
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
    public function get_User($user): false|array
    {
        $result = parent::get_Cached($user);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     *  Este metodo consulta en tiempo real si un usuario, tiene un permiso especifico asignado en alguno
     *  de sus roles retornando falso o verdadero segun sea el caso.
     *  Por que no usamos un JOIN por que como los modelos estan cacheados la resulta ya esta economizada,
     *  maxime solo si se hace de este modo.
     **/
    public function has_Permission($user, $hpermission)
    {
        if (!empty($user) && !empty($hpermission)) {
            if ($user != 'anonymous') {
                $mpermissions = model("\App\Modules\Security\Models\Security_Permissions");
                $mpolicies = model("App\Modules\Security\Models\Security_Policies");
                $mhierarchies = model("App\Modules\Security\Models\Security_Hierarchies");
                $permission = $mpermissions->get_PermissionByAlias($hpermission);
                $roles = $mhierarchies->getHierarchiesByUser($user);
                if (is_array($roles)) {
                    foreach ($roles as $rol) {
                        if (isset($rol['rol']) && strlen($permission) >= 13) {
                            $has = $mpolicies->get_Policy($rol['rol'], $permission);
                            if ($has) {
                                return (true);
                            }
                        }

                    }
                }
            }
        }
        return (false);
    }

    /**
     * Retorna falso o verdadero si el usuario activo ne la sesión es el
     * autor del regsitro que se desea acceder, editar o eliminar.
     * @param type $id codigo primario del registro a consultar
     * @param type $author codigo del usuario del cual se pretende establecer la autoria
     * @return boolean falso o verdadero segun sea el caso
     */
    public function get_Authority($id, $author): bool
    {
        $row = parent::get_CachedFirst([$this->primaryKey => $id]);
        if (isset($row["author"]) && $row["author"] == $author) {
            return (true);
        } else {
            return (false);
        }
    }


    /**
     * Obtiene la clave de caché para un identificador dado.
     * @param $user
     * @return array|false
     */
    public function getCachedProfile($user): array|false
    {
        $key = $this->getCacheKey($user);
        $cache = $this->readCache($key);
        if ($cache === null) {
            $cache = $this->getProfile($user);
            $this->saveCache($key, $cache);
        }
        return $cache;
    }


    public function getAvatar($user){
        $avatar="/themes/assets/images/profile-portrait.png";
        $mattachments = model('App\Modules\Security\Models\Security_Users_Fields');
        $avatar = $mattachments->get_Avatar($user);

        // Medida de seguridad: verificar si cdn_url está disponible
        if (!function_exists('cdn_url')) {
            return "";
        }

        $src = cdn_url($avatar);
        return ($src);
    }



    /**
     * Este metodo obtiene el perfil de un usuario específico, incluyendo campos personalizados
     * Cambios realizados:
     * 1) Subconsultas para cada campo: Se utiliza una subconsulta para obtener el valor más reciente basado en created_at.
     * 2) Ordenación explícita: Las subconsultas incluyen ORDER BY created_at DESC para garantizar que se seleccionen los datos más recientes.
     * 3) Última actualización: Se utiliza una subconsulta separada para obtener la fecha más reciente de created_at.
     * @param $userId
     * @return array
     */
    public function getProfile($userId):array | false
    {
        if(strlen($userId)>=10) {
            // Obtener los nombres de los campos distintos
            $fields = $this->getDistinctFieldNames($userId);

            // Si no se encuentran campos, devolver un array vacío
            if (empty($fields)) {
                return [];
            }

            // Construir dinámicamente las columnas con CASE WHEN
            $selectColumns = [];
            foreach ($fields as $field) {
                $fieldName = $field['name'];
                $alias = str_replace(['-', ' '], '_', $fieldName); // Reemplazar caracteres no válidos
                $selectColumns[] = "(
            SELECT suf.value
            FROM security_users_fields suf
            WHERE suf.user = su.user AND suf.name = '{$fieldName}'
            ORDER BY suf.created_at DESC
            LIMIT 1
        ) AS `{$alias}`";
            }

            // Agregar la columna para la última actualización
            $selectColumns[] = "(
        SELECT MAX(suf.created_at)
        FROM security_users_fields suf
        WHERE suf.user = su.user
    ) AS latest_update";

            // Construir la consulta
            $builder = $this->db->table('security_users su');
            $builder
                ->select(array_merge(['su.user'], $selectColumns))
                ->where('su.user', $userId);

            // Ejecutar la consulta y devolver los resultados
            $query = $builder->get();
            $return= $query->getRowArray();
            $return['avatar'] =$this->getAvatar($userId);
            return($return);
        }else{
            return false;
        }
    }

    /**
     * Obtiene los nombres de los campos distintos para un usuario específico.
     * @param int $userId El ID del usuario.
     * @return array Un array con los nombres de los campos distintos.
     */
    public function getDistinctFieldNames($userId)
    {
        $builder = $this->db->table('security_users_fields');
        $query = $builder
            ->distinct()
            ->select('name')
            ->where('user', $userId)
            ->get();

        return $query->getResultArray();
    }


}

?>