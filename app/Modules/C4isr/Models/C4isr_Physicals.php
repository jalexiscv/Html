<?php

namespace App\Modules\C4isr\Models;

use Higgs\Model;
use Config\Database;

class C4isr_Physicals extends Model
{
    protected $table = "c4isr_physicals";
    protected $primaryKey = "physical";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "physical",
        "profile",
        "height",
        "weight",
        "skin_color",
        "eye_color",
        "eye_shape",
        "eye_size",
        "hair_color",
        "hair_type",
        "hair_length",
        "face_shape",
        "nose_size_shape",
        "ear_size_shape",
        "lip_size_shape",
        "chin_size_shape",
        "facial_hair_presence_type",
        "eyebrow_presence_type",
        "moles_freckles_birthmarks_presence_location",
        "scars_presence_location",
        "tattoos_presence_location",
        "piercings_presence_location",
        "interpupillary_distance",
        "eyes_forehead_distance",
        "nose_mouth_distance",
        "shoulder_width",
        "arm_length",
        "hand_size_shape",
        "finger_size_shape",
        "nail_size_shape",
        "leg_length",
        "foot_size_shape",
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
                'physical' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'profile' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'height' => ['type' => 'FLOAT', 'null' => FALSE],
                'weight' => ['type' => 'FLOAT', 'null' => FALSE],
                'skin_color' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'eye_color' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'eye_shape' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'eye_size' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'hair_color' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'hair_type' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'hair_length' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'face_shape' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'nose_size_shape' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'ear_size_shape' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'lip_size_shape' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'chin_size_shape' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'facial_hair_presence_type' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'eyebrow_presence_type' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'moles_freckles_birthmarks_presence_location' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'scars_presence_location' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'tattoos_presence_location' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'piercings_presence_location' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'interpupillary_distance' => ['type' => 'FLOAT', 'null' => FALSE],
                'eyes_forehead_distance' => ['type' => 'FLOAT', 'null' => FALSE],
                'nose_mouth_distance' => ['type' => 'FLOAT', 'null' => FALSE],
                'shoulder_width' => ['type' => 'FLOAT', 'null' => FALSE],
                'arm_length' => ['type' => 'FLOAT', 'null' => FALSE],
                'hand_size_shape' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'finger_size_shape' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'nail_size_shape' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'leg_length' => ['type' => 'FLOAT', 'null' => FALSE],
                'foot_size_shape' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
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

    protected function get_CacheKey($id)
    {
        return (APPNODE . '_' . $this->table . '_' . str_replace('\\', '_', get_class($this)) . '_' . $id);
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
     * Actualiza un registo y actualiza el chache
     */
    public function update($id = null, $data = null): bool
    {
        $result = parent::update($id, $data);
        if ($result === true) {
            $cache_key = $this->get_CacheKey($id);
            $data = parent::find($id);
            cache()->save($cache_key, $data, $this->cache_time);
        }
        return ($result);
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