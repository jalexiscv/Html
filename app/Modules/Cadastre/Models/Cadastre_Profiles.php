<?php

namespace App\Modules\Cadastre\Models;

use Higgs\Model;
use Config\Database;

class Cadastre_Profiles extends Model
{
    protected $table = "cadastre_profiles";
    protected $primaryKey = "profile";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "profile",
        "type",
        "customer",
        "registration",
        "citizenship_card",
        "names",
        "firstname",
        "lastname",
        "address",
        "notification_address",
        "cycle",
        "stratum",
        "use_type",
        "consumption",
        "service",
        "neighborhood_description",
        "unit_id",
        "phone",
        "email",
        "entry_date",
        "reading_route",
        "national_property_number",
        "realestate_registration",
        "rate",
        "route_sequence",
        "diameter",
        "meter_number",
        "historical",
        "longitude",
        "latitude",
        "status",
        "anotation",
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
    protected $version = '1.0.0';
    protected $cache_time = 60;
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
                'profile' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'customer' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'type' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => TRUE],
                'registration' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
                'citizenship_card' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'names' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'firstname' => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => TRUE],
                'lastname' => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => TRUE],
                'address' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'notification_address' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'cycle' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => FALSE],
                'stratum' => ['type' => 'VARCHAR', 'constraint' => 32, 'null' => FALSE],
                'use_type' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => FALSE],
                'consumption' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'service' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'neighborhood_description' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => FALSE],
                'unit_id' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => FALSE],
                'phone' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'email' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'entry_date' => ['type' => 'DATE', 'null' => FALSE],
                'reading_route' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'national_property_number' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'realestate_registration' => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => FALSE],
                'rate' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'route_sequence' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'diameter' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => FALSE],
                'meter_number' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => FALSE],
                'historical' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'longitude' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'latitude' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
                'status' => ['type' => 'ENUM', 'constraint' => ['ACTIVE', 'INACTIVE'], 'default' => 'ACTIVE'],
                'anotation' => ['type' => 'ENUM', 'constraint' => ['ORIGINAL', 'CENSUS', 'APPROVED'], 'default' => 'ACTIVE'],
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
            ->join('cadastre_profiles', 'cadastre_customers.customer = cadastre_profiles.customer')
            ->select('cadastre_customers.*, cadastre_profiles.*')
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
                ->join('cadastre_profiles', 'cadastre_customers.customer = cadastre_profiles.customer')
                ->select('cadastre_customers.*, cadastre_profiles.*')
                ->groupStart()
                ->like("cadastre_customers.customer", "%{$search}%")
                ->orLike("cadastre_customers.registration", "%{$search}%")
                ->groupEnd()
                ->orderBy("cadastre_customers.registration", "DESC")
                ->countAllResults();
        } else {
            $result = $this
                ->join('cadastre_profiles', 'cadastre_customers.customer = cadastre_profiles.customer')
                ->select('cadastre_customers.*, cadastre_profiles.*')
                ->orderBy("cadastre_customers.registration", "DESC")
                ->countAllResults();
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


    public function get_Routes()
    {
        $result = $this
            ->select("reading_route AS route, COUNT(DISTINCT registration) AS count")
            ->where('status', 'ACTIVE')
            ->groupBy("route")
            ->orderBy("route", "ASC")
            ->findAll();
        return (is_array($result) ? $result : false);
    }

    protected function _exec_beforeFind(array $data)
    {
        if (isset($data['id']) && $item = $this->get_CachedItem($data['id'])) {
            //echo("Cacheado");
            $data['data'] = $item;
            $data['returnData'] = true;
            return $data;
        } else {
            //echo("No Cacheado");
        }
    }

    private function get_CachedItem($id)
    {
        $cacheKey = $this->get_CacheKey($id);
        $cachedData = cache($cacheKey);
        return $cachedData !== null ? $cachedData : false;
    }

    protected function _exec_findCache(array $data)
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