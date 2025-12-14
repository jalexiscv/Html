<?php
namespace App\Modules\Security\Models;

use Higgs\Model;
use Config\Database;

class Security_Permissions extends Model
{
    protected $table = "security_permissions";
    protected $primaryKey = "permission";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "permission",
        "alias",
        "module",
        "description",
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
    protected $cache_time = 18000;
    protected $version = "1.0.0";

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        //$this->regenerate();
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
        if (!$this->tableExists()) {
            $forge = Database::forge($this->DBGroup);
            $fields = [
                'permission' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'alias' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
                'module' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'description' => ['type' => 'TEXT', 'null' => FALSE],
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
    private function tableExists()
    {
        $cache_key = $this->get_CacheKey($this->table);
        if (!$data = cache($cache_key)) {
            $data = $this->db->tableExists($this->table);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($data);
    }

    public function get_CacheKey($id)
    {
        $node = APPNODE;
        $table = $this->table;
        $class = str_replace('\\', '_', get_class($this));
        $version = $this->version;
        $key = "{$node}-{$table}-{$class}-{$version}-{$id}";
        return (md5($key));
    }

    /**
     * Retorna el codigo del permiso proporsionando su alias.
     * @param type $alias
     * @return type
     */
    public function get_PermissionByAlias($alias)
    {

        $cache_key = $this->get_CacheKey("permissions-{$alias}");
        $cache = cache($cache_key);
        if (!$this->is_CacheValid($cache)) {
            $value = false;
            $row = $this->where('alias', strtoupper($alias))->first();
            if (is_array($row) && !empty($row["permission"])) {
                $value = $row['permission'];
            }
            $cache = array('value' => $value, 'retrieved' => true);
            cache()->save($cache_key, $cache, $this->cache_time);
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
        return !is_null($cache) && is_array($cache) && isset($cache['retrieved']);
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

        }
        return ($result);
    }


    public function get_Total($search = "")
    {
        if (!empty($search)) {
            $result = $this
                ->where("deleted_at", NULL)
                ->groupStart()
                ->like("permission", "%{$search}%")
                ->orLike("alias", "%{$search}%")
                ->groupEnd()
                ->orderBy("created_at", "DESC")
                ->countAllResults();
        } else {
            $result = $this
                ->where("deleted_at", NULL)
                ->orderBy("created_at", "DESC")
                ->countAllResults();
        }
        return ($result);
    }


    /**
     * Obtiene una lista de registros combinados de cadastre_customers y cadastre_profiles
     * con opciones de filtrado y paginación.
     * @param int $limit El número máximo de registros a obtener por página.
     * @param int $offset El número de registros a omitir antes de comenzar a seleccionar.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return array|false    Un arreglo de registros combinados o false si no se encuentran registros.
     */

    public function get_List($limit, $offset, $search = "")
    {
        $result = $this
            ->where("deleted_at", NULL)
            ->groupStart()
            ->like("permission", "%{$search}%")
            ->orLike("alias", "%{$search}%")
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
     * Actualiza un registo y actualiza el chache
     */
    public function update($id = null, $data = null): bool
    {
        $result = parent::update($id, $data);
        if ($result === true) {

        }
        return ($result);
    }

    /**
     * Retorna resultados cacheados
     */
    public function find($id = null)
    {
        $cache_key = $this->get_CacheKey($id);
        if (!$data = cache($cache_key)) {
            $data = parent::find($id);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($data);
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
