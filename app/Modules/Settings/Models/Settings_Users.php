<?php

namespace App\Modules\Settings\Models;

use Higgs\Model;
use Config\Database;

class Settings_Users extends Model
{
    protected $table = "settings_users";
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
    protected $beforeFind = ['_exec_BeforeFind'];
    protected $afterFind = ['_exec_FindCache'];
    protected $afterInsert = ['_exec_UpdateCache'];
    protected $afterUpdate = ['_exec_UpdateCache'];
    protected $afterDelete = ['_exec_DeleteCache'];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "authentication";//default
    protected $version = '1.0.0';
    protected $cache_time = 60;
    protected $cache;

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        $this->exec_TableRegenerate();
    }

    /**
     * Regenera o recrea la tabla de la base de datos en caso de que esta no exista
     * Ejemplo de campos
     * $fields = [
     *      'id'=> ['type'=>'INT','constraint'=> 5,'unsigned'=> true,'auto_increment' => true],
     *      'title'=>['type'=> 'VARCHAR','constraint'=>'100','unique'  => true,],
     *      'author'=>['type'=>'VARCHAR','constraint'=> 100,'default'=> 'King of Town',],
     *      'description'=>['type'=>'TEXT','null'=>true,],
     *      'status'=>['type'=>'ENUM','constraint'=>['publish','pending','draft'],'default'=>'pending',],
     *   ];
     */
    private function exec_TableRegenerate()
    {
        if (!$this->get_TableExist()) {
            $forge = Database::forge($this->DBGroup);
            $fields = [
                'user' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'created_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'updated_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'deleted_at' => ['type' => 'DATETIME', 'null' => TRUE],
            ];
            $forge->addField($fields);
            $forge->addPrimaryKey($this->primaryKey);
            //$forge->addKey('post');
            //$forge->addKey('profile');
            $forge->addKey('author');
            $forge->createTable($this->table, TRUE);
        }
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
    private function get_TableExist()
    {
        $cache_key = $this->get_CacheKey($this->table);
        if (!$data = cache($cache_key)) {
            $data = $this->db->tableExists($this->table);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return $data;
    }

    /**
     * Obtiene la clave de caché para un identificador dado.
     * @param mixed $id Identificador único para el objeto en caché.
     * @return string Clave de caché generada para el identificador.
     **/
    protected function get_CacheKey($id)
    {
        $id = is_array($id) ? implode("", $id) : $id;
        $node = APPNODE;
        $table = $this->table;
        $class = urlencode(get_class($this));
        $version = $this->version;
        $key = "{$node}-{$table}-{$class}-{$version}-{$id}";
        return md5($key);
    }

    public function get_CountAllResults($search = "")
    {
        $result = $this->countAllResults();
        return ($result);
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
        $key = $this->get_CacheKey("{$id}{$author}");
        $cache = cache($key);
        if (!$this->is_CacheValid($cache)) {
            $row = $this->where($this->primaryKey, $id)->first();
            if (isset($row["author"]) && $row["author"] == $author) {
                $value = true;
            } else {
                $value = false;
            }
            $cache = array('value' => $value, 'retrieved' => true);
            cache()->save($key, $cache, $this->cache_time);
        }
        return ($cache['value']);
    }

    /**
     * Método is_CacheValid
     * Este método verifica si los datos recuperados de la caché son válidos.
     * @param mixed $cache - Los datos recuperados de la caché.
     * @return bool - Devuelve true si los datos de la caché son válidos, false en caso contrario.
     */
    private function is_CacheValid($cache): bool
    {
        return is_array($cache) && array_key_exists('retrieved', $cache) && $cache['retrieved'] === true;
    }

    /**
     * Obtiene una lista de usuarios combinados con sus campos personalizados (alias, firstname, lastname, phone, address, email, avatar)
     * con opciones de filtrado y paginación. Los campos personalizados se obtienen de la tabla settings_users_fields.
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
            $subQuery = $this->db->table('settings_users_fields')
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
                    FROM settings_users_fields rsf_inner
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

    /**
     * Obtiene el número total de registros combinados de con opciones de filtrado.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return int    El número total de registros.
     */
    public function get_Total($search = "")
    {
        $query = $this->db->table('settings_users su');
        $query->select('su.user');
        $query->select("MAX(CASE WHEN rsf.name = 'alias' THEN rsf.value END) AS alias");
        $query->select("MAX(CASE WHEN rsf.name = 'firstname' THEN rsf.value END) AS firstname");
        $query->select("MAX(CASE WHEN rsf.name = 'lastname' THEN rsf.value END) AS lastname");
        $query->select("MAX(CASE WHEN rsf.name = 'phone' THEN rsf.value END) AS phone");
        $query->select("MAX(CASE WHEN rsf.name = 'address' THEN rsf.value END) AS address");
        $query->select("MAX(CASE WHEN rsf.name = 'email' THEN rsf.value END) AS email");
        $query->join('settings_users_fields rsf', 'su.user = rsf.user', 'inner');
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
     * Se cacheo en este punto debido aque hacer cache en la consulta llevaría al uso de demasiados archivos
     * lo cual haria extensa la lectura.
     * @param $user
     * @param $permission
     * @return \Higgs\Cache\CacheInterface|bool|mixed
     */
    public function has_Permission($user, $permission)
    {
        $cache_key = $this->get_CacheKey("{$user}-{$permission}");
        if (!$data = cache($cache_key)) {
            $data = $this->_has_Permission($user, $permission);
            cache()->save($cache_key, $data, $this->cache_time * 10);
        }
        return ($data);

    }

    /**
     *  Este metodo consulta en tiempo real si un usuario, tiene un permiso especifico asignado en alguno
     *  de sus roles retornando falso o verdadero segun sea el caso.
     *  Por que no usamos un JOIN por que como los modelos estan cacheados la resulta ya esta economizada,
     *  maxime solo si se hace de este modo.
     **/
    private function _has_Permission($user, $hpermission)
    {
        if (!empty($user) && !empty($hpermission)) {
            if ($user != 'anonymous') {
                $mpermissions = model("\App\Modules\Settings\Models\Settings_Permissions");
                $mpolicies = model("App\Modules\Settings\Models\Settings_Policies");
                $mhierarchies = model("App\Modules\Settings\Models\Settings_Hierarchies");
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

    protected function _exec_BeforeFind(array $data)
    {
        if (isset($data['id']) && $item = $this->get_CachedItem($data['id'])) {
            $data['data'] = $item;
            $data['returnData'] = true;
            return $data;
        }
    }


    private function get_CachedItem($id)
    {
        $cacheKey = $this->get_CacheKey($id);
        $cachedData = cache($cacheKey);
        return $cachedData !== null ? $cachedData : false;
    }

    protected function _exec_FindCache(array $data)
    {
        $id = $data['id'] ?? null;
        cache()->save($this->get_CacheKey($id), $data['data'], $this->cache_time);
        return ($data);
    }

    /**
     * Implementa la lógica para actualizar la caché después de insertar o actualizar
     * Por ejemplo, puedes utilizar la misma lógica que en exec_beforeFind
     * y guardar los datos en la caché usando cache().
     * @param array $data
     * @return void
     */

    protected function _exec_UpdateCache(array $data)
    {
        $id = $data['id'] ?? null;
        if ($id !== null) {
            $updatedData = $this->find($id);
            if ($updatedData) {
                cache()->save($this->get_CacheKey($id), $updatedData, $this->cache_time);
            }
        }
    }

    /**
     * Implementa la lógica para eliminar la caché después de eliminar
     * Por ejemplo, puedes utilizar la misma lógica que en exec_beforeFind
     * para invalidar la caché.
     * @param array $data
     * @return void
     */
    protected function _exec_DeleteCache(array $data)
    {
        $id = $data['id'] ?? null;
        if ($id !== null) {
            $deletedData = $this->find($id);
            if ($deletedData) {
                cache()->delete($this->get_CacheKey($id));
            }
        }
    }
}

?>