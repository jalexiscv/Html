<?php

namespace App\Modules\Cadastre\Models;

use Higgs\Model;
use Config\Database;

class Cadastre_Georeferences extends Model
{
    protected $table = "cadastre_georeferences";
    protected $primaryKey = "georeference";
    protected $returnType = "array";
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        "georeference",
        "registration",
        "latitud",
        "latitude_degrees",
        "latitude_minutes",
        "latitude_seconds",
        "latitude_decimal",
        "longitude",
        "longitude_degrees",
        "longitude_minutes",
        "longitude_seconds",
        "longitude_decimal",
        "date",
        "time",
        "author",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
    protected $beforeFind = ['_exec_beforeFind'];
    protected $afterFind = ['_exec_findCache'];
    protected $afterInsert = ['_exec_updateCache'];
    protected $afterUpdate = ['_exec_updateCache'];
    protected $afterDelete = ['_exec_deleteCache'];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "authentication";//default
    protected $version = '1.0.1';
    protected $cache_time = 30;
    protected $cache;

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
        if (!$this->tableExists()) {
            $forge = Database::forge($this->DBGroup);
            $fields = [
                'georeference' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'registration' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'latitud' => ['type' => 'ENUM', 'null' => FALSE],
                'latitude_degrees' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => FALSE],
                'latitude_minutes' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => FALSE],
                'latitude_seconds' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => FALSE],
                'latitude_decimal' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => FALSE],
                'longitude' => ['type' => 'ENUM', 'null' => FALSE],
                'longitude_degrees' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => FALSE],
                'longitude_minutes' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => FALSE],
                'longitude_seconds' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => FALSE],
                'longitude_decimal' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => FALSE],
                'date' => ['type' => 'DATE', 'null' => FALSE],
                'time' => ['type' => 'TIME', 'null' => FALSE],
                'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'created_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'updated_at' => ['type' => 'DATETIME', 'null' => TRUE],
                'deleted_at' => ['type' => 'DATETIME', 'null' => TRUE],
            ];
            $forge->addField($fields);
            $forge->addPrimaryKey($this->primaryKey);
//$forge->addKey('post');
//$forge->addKey('registration');
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
        return $data;
    }

    /**
     * Obtiene la clave de caché para un identificador dado.
     * @param mixed $id Identificador único para el objeto en caché.
     * @return string Clave de caché generada para el identificador.
     **/
    protected function get_CacheKey($id)
    {
        $node = APPNODE;
        $table = $this->table;
        $class = urlencode(get_class($this));
        $version = $this->version;
        $key = "{$node}-{$table}-{$class}-{$version}-{$id}";
        return md5($key);
    }

    /**
     * Obtiene una lista de registros combinados de cadastre_customers y cadastre_registrations
     * con opciones de filtrado y paginación.
     * @param int $limit El número máximo de registros a obtener por página.
     * @param int $offset El número de registros a omitir antes de comenzar a seleccionar.
     * @param string $search (Opcional) El término de búsqueda para filtrar resultados.
     * @return array|false    Un arreglo de registros combinados o false si no se encuentran registros.
     */

    public function get_List($limit, $offset, $search = "")
    {
        $result = $this
            ->join('cadastre_registrations', 'cadastre_customers . customer = cadastre_registrations . customer')
            ->select('cadastre_customers .*, cadastre_registrations .*')
            ->groupStart()
            ->like("cadastre_customers.customer", "%{$search}%")
            ->orLike("cadastre_customers.registration", "%{$search}%")
            ->groupEnd()
            ->orderBy("cadastre_customers.registration", "DESC")
            ->findAll($limit, $offset);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_CountAllResults($search = "")
    {
        if (!empty($search)) {
            $result = $this
                ->join('cadastre_registrations', 'cadastre_customers . customer = cadastre_registrations . customer')
                ->select('cadastre_customers .*, cadastre_registrations .*')
                ->groupStart()
                ->like("cadastre_customers.customer", "%{$search}%")
                ->orLike("cadastre_customers.registration", "%{$search}%")
                ->groupEnd()
                ->orderBy("cadastre_customers.registration", "DESC")
                ->countAllResults();
        } else {
            $result = $this
                ->join('cadastre_registrations', 'cadastre_customers . customer = cadastre_registrations . customer')
                ->select('cadastre_customers .*, cadastre_registrations .*')
                ->orderBy("cadastre_customers.registration", "DESC")
                ->countAllResults();
        }
        return ($result);
    }


    public function get_ByRegistration($registration)
    {
        //echo("Registration: {$registration}");
        $key = $this->get_CacheKey("{$registration}");
        $cache = cache($key);
        if (!$this->is_CacheValid($cache)) {
            $result = $this
                ->where('registration', $registration)
                ->orderBy("date,time", "DESC")
                ->first();
            //print_r($result);
            if (is_array($result)) {
                $cache = array('value' => $result, 'retrieved' => true);
            } else {
                $cache = array('value' => false, 'retrieved' => true);
            }
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

    protected function _exec_findCache(array $data)
    {
        $id = $data['id'] ?? null;
        cache()->save($this->get_CacheKey($id), $data['data'], $this->cache_time);
        return ($data);
    }

    protected function _exec_beforeFind(array $data)
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

    /**
     * Implementa la lógica para actualizar la caché después de insertar o actualizar
     * Por ejemplo, puedes utilizar la misma lógica que en exec_beforeFind
     * y guardar los datos en la caché usando cache().
     * @param array $data
     * @return void
     */

    protected function _exec_updateCache(array $data)
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
    protected function _exec_deleteCache(array $data)
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