<?php
namespace App\Modules\Security\Models;

use Higgs\Model;
use Config\Database;

class Security_Logs extends Model
{
    protected $table = "security_logs";
    protected $primaryKey = "log";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "log",
        "user",
        "ip",
        "action",
        "date",
        "time",
        "views",
        "referer_url",
        "location_latitude",
        "location_longitude",
        "location_country",
        "location_region",
        "location_city",
        "browser_engine",
        "browser_name",
        "browser_version",
        "device_brand",
        "device_model",
        "device_type",
        "os",
        "version",
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

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     **/
    public function __construct()
    {
        parent::__construct();
        $this->regenerate();
    }

    /**
     * /**
     * Regenera o recrea la tabla de la base de datos en caso de que esta no exista
     * Ejemplo de campos
     * $fields = [
     *      'id'=> ['type'=>'INT','constraint'=> 5,'unsigned'=> true,'auto_increment' => true],
     *      'title'=>['type'=> 'VARCHAR','constraint'=>'100','unique'  => true,],
     *      'author'=>['type'=>'VARCHAR','constraint'=> 100,'default'=> 'King of Town',],
     *      'description'=>['type'=>'TEXT','null'=>true,],
     *      'status'=>['type'=>'ENUM','constraint'=>['publish','pending','draft'],'default'=>'pending',],
     *   ];
     * @param type $year
     * @param type $month
     */
    public function regenerate()
    {
        if (!$this->tableExists($this->table)) {
            $forge = Database::forge($this->DBGroup);
            $fields = [
                'log' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'user' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'ip' => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => FALSE],
                'action' => ['type' => 'VARCHAR', 'constraint' => 16, 'null' => FALSE],
                'date' => ['type' => 'DATE', 'null' => FALSE],
                'time' => ['type' => 'TIME', 'null' => FALSE],
                'views' => ['type' => 'INT', 'constraint' => 10, 'null' => TRUE],
                'referer_url' => ['type' => 'TINYTEXT', 'null' => TRUE],
                'location_latitude' => ['type' => 'DECIMAL', 'null' => TRUE],
                'location_longitude' => ['type' => 'DECIMAL', 'null' => TRUE],
                'location_country' => ['type' => 'VARCHAR', 'constraint' => 3, 'null' => TRUE],
                'location_region' => ['type' => 'VARCHAR', 'constraint' => 3, 'null' => TRUE],
                'location_city' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => TRUE],
                'browser_engine' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => TRUE],
                'browser_name' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => TRUE],
                'browser_version' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => TRUE],
                'device_brand' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => TRUE],
                'device_model' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => TRUE],
                'device_type' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => TRUE],
                'os' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => TRUE],
                'version' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => TRUE],
                'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => TRUE],
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
            cache()->save($cache_key, $data, $this->cache_time * 1000);
        }
        return ($data);
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
     * Retorna el listado de elementos existentes
     * un mes de un año especifico.
     * @param type $year
     * @param type $month
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


}

?>
