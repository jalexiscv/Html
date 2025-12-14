<?php

namespace App\Modules\Security\Models;

use Higgs\Debug\Toolbar\Collectors\Caches;
use Higgs\Model;
use Config\Database;

class Security_Policies extends Model
{
    protected $table = "security_policies";
    protected $primaryKey = "policy";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "policy",
        "rol",
        "permission",
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
    protected $cache_time = 21600;
    protected $version = "1.0.2";

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        $this->regenerate();
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
    public function regenerate()
    {
        if (!$this->tableExists($this->table)) {
            $forge = Database::forge($this->DBGroup);
            $fields = [
                'policy' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'rol' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'permission' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
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
    private function tableExists($tableName)
    {
        $cache_key = '_table_exist_' . APPNODE . '_' . $this->table;
        if (!$data = cache($cache_key)) {
            $data = $this->db->tableExists($tableName);
            cache()->save($cache_key, $data, $this->cache_time * 10);
        }
        return ($data);
    }

    public function get_Policy(string $rol, string $permission): bool
    {
        $key = $this->get_CacheKey("policies-{$rol}-{$permission}");
        $cache = cache($key);
        if (!$this->is_CacheValid($cache)) {
            $ttl = $this->cache_time;
            $data = $this->_get_Policy($rol, $permission);
            Caches::addMessage('Create', "{$key} : Politica {$rol}x{$permission}", $ttl);
            $cache = array('value' => $data, 'retrieved' => true, "expire" => time() + $ttl);
            cache()->save($key, $cache, $ttl);
        }
        $remaining = $cache['expire'] - time();
        Caches::addMessage('Read', "{$key} : Politica {$rol}x{$permission}", $remaining);
        return ($cache['value']);
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

    /**
     * Método get_RolxPermission
     *
     * Este método verifica si un rol específico tiene un permiso específico.
     * Utiliza el método 'where' dos veces para filtrar registros que coincidan
     * con los parámetros proporcionados y luego obtiene el primer registro que
     * cumple con estos criterios.
     * @param string $rol - El rol a verificar.
     * @param string $permission - El permiso a verificar.
     * @return bool - Devuelve true si el rol tiene el permiso especificado (es decir, si existe un registro con 'rol' y 'permission' que además contiene 'policy').
     *                En caso contrario, devuelve false.
     * @throws \Higgs\Database\Exceptions\DatabaseException - Puede lanzar una excepción si la consulta a la base de datos falla.
     */
    private function _get_Policy(string $rol, string $permission): bool
    {
        try {
            $has = $this->where('rol', $rol)->where('permission', $permission)->first();
            if (is_array($has) && isset($has['policy'])) {
                return (true);
            }
            return (false);
        } catch (\Higgs\Database\Exceptions\DatabaseException $e) {
            throw $e;
        }
    }

    /**
     * Establece una nueva política y elimina la caché si es necesario.
     * @param string $rol - El rol al que se le asignará el permiso.
     * @param string $permission - El permiso que se asignará al rol.
     * @return bool - Devuelve true si la política se establece correctamente, false en caso contrario.
     */
    public function set_Policy(string $rol, string $permission): bool
    {
        $result = $this->insert(array(
            "policy" => pk(),
            "rol" => $rol,
            "permission" => $permission,
            "author" => safe_get_user()
        ));
        $key = $this->get_CacheKey("policies-{$rol}-{$permission}");
        cache()->delete($key);
        cache()->clean();
        return ($result);
    }

    /**
     * Elimina una política y elimina la caché si es necesario.
     * @param string $rol - El rol al que se le asignará el permiso.
     * @param string $permission - El permiso que se asignará al rol.
     * @return bool - Devuelve true si la política se elimina correctamente, false en caso contrario.
     */
    public function delete_Policy(string $rol, string $permission): bool
    {
        $result = $this->where('rol', $rol)->where('permission', $permission)->delete();
        $key = $this->get_CacheKey("policies-{$rol}-{$permission}");
        cache()->delete($key);
        return ($result);
    }

    /**
     * Retorna el listado de elementos existentes
     * un mes de un año especifico.
     * @param type $year
     * @param type $month
     */
    public function get_List()
    {
        $sql = "SELECT * FROM `{$this->table}` ORDER BY `reference` ASC;";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
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
        $row = $this->where($this->primaryKey, $id)->first();
        if (@$row["author"] == $author) {
            return (true);
        } else {
            return (false);
        }
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
     * Retorna falso o verdadero si el usuario activo ne la sesión es el
     * autor del regsitro que se desea acceder, editar o eliminar.
     * @param type $id codigo primario del registro a consultar
     * @param type $author codigo del usuario del cual se pretende establecer la autoria
     * @return boolean falso o verdadero segun sea el caso
     */
    public function delete_AllByRol($rol)
    {
        $row = $this->where("rol", $rol)->delete();
        if ($row) {
            return (true);
        } else {
            return (false);
        }
    }

    /**
     * Obtiene el número total de registros que coinciden con un término de búsqueda.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return int Devuelve el número total de registros que coinciden con el término de búsqueda.
     */
    function get_Total(string $search = ""): int
    {
        $result = $this
            ->groupStart()
            ->orLike("rol", "%{$search}%")
            ->orLike("permission", "%{$search}%")
            ->orLike("author", "%{$search}%")
            ->groupEnd()
            ->countAllResults();
        return ($result);
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

    /**
     * Este método verifica si la tabla especificada existe en la base de datos utilizando la función tableExists()
     * del objeto db de Higgs. Además, utiliza la caché para almacenar el resultado de la verificación para mejorar
     * el rendimiento y evitar la sobrecarga de la base de datos. La clave de caché se crea utilizando el método
     * get_CacheKey(), que se supone que retorna una clave única para la tabla especificada. El tiempo de duración de
     * la caché se establece en el atributo $cache_time.
     * @return bool Devuelve true si la tabla existe, false en caso contrario.
     */
    private function get_TableExist(): bool
    {
        $cache_key = $this->get_CacheKey($this->table);
        if (!$data = cache($cache_key)) {
            $data = $this->db->tableExists($this->table);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return $data;
    }


}

?>