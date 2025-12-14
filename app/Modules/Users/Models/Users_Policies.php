<?php

namespace App\Modules\Users\Models;

use Higgs\Model;
use Config\Database;

class Users_Policies extends Model
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
    protected $cache_time = 60;

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
        $cache_key = $this->get_CacheKey("policies-{$rol}-{$permission}");
        $cache = cache($cache_key);
        if (!$this->is_CacheValid($cache)) {
            $value = $this->_get_Policy($rol, $permission);
            $cache = array('value' => $value, 'retrieved' => true);
            cache()->save($cache_key, $cache, $this->cache_time * 10);
        }
        return ($cache['value']);
    }

    protected function get_CacheKey($id)
    {
        return md5(APPNODE . '_' . $this->table . '_' . str_replace('\\', '_', get_class($this)) . '_' . $id);
    }

    /**
     * Método is_CacheValid
     * Este método verifica si los datos recuperados de la caché son válidos.
     * @param mixed $cache - Los datos recuperados de la caché.
     * @return bool - Devuelve true si los datos de la caché son válidos, false en caso contrario.
     */
    private function is_CacheValid($cache): bool
    {
        return !is_null($cache) && is_array($cache) && isset($cache['retrieved']);
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
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            throw $e;
        }
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
     * Inserta un nuevo registo y actualiza el chache
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
     * Retorna resultados cacheados
     */
    public function find($id = null)
    {
        $key = $this->get_CacheKey("{$id}");
        $cache = cache($key);
        if (!$this->is_CacheValid($cache)) {
            $value = parent::find($id);
            $cache = array('value' => $value, 'retrieved' => true);
            cache()->save($key, $cache, $this->cache_time);
        }
        return ($cache['value']);
    }


    /**
     * Actualiza un registo y actualiza el chache
     */
    public function update($id = null, $data = null): bool
    {
        $result = parent::update($id, $data);
        if ($result === true) {
            $data = parent::find($id);
        }
        return ($result);
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
     * Elimina un registo y actualiza el chache
     */
    public function delete($id = null, $purge = false)
    {
        $result = parent::delete($id, $purge);
        if ($result === true) {
            cache()->delete($this->get_CacheKey($id));
        }
        return ($result);
    }
}

?>