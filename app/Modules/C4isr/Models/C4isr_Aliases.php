<?php

namespace App\Modules\C4isr\Models;

use Higgs\Model;
use Config\Database;

class C4isr_Aliases extends Model
{
    protected $table = "c4isr_aliases";
    protected $primaryKey = "alias";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "alias",
        "profile",
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
                'alias' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'profile' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
                'user' => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => FALSE],
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


    public function query_UnionByProfile($patron, $limit, $offset)
    {
        $tablas = $this->db->query("SHOW TABLES LIKE 'c4isr_aliases_%'")->getResultArray();
        $sql = "SELECT * FROM (";
        $uniones = [];
        foreach ($tablas as $tabla) {
            $nombreTabla = array_values($tabla)[0];
            $uniones[] = "SELECT * FROM `{$nombreTabla}`";
        }
        $sql .= implode(" UNION ALL ", $uniones);
        $sql .= ") AS all_aliases ";
        $sql .= !empty($patron) ? "WHERE `profile` LIKE '%" . $this->db->escapeLikeString($patron) . "%'" : "";
        $sql .= " LIMIT " . intval($offset) . "," . intval($limit) . ";";
        $query = $this->db->query($sql);
        return ($query->getResultArray());
    }


    public function query_Union($patron, $limit, $offset)
    {
        $sql = "SELECT * FROM (";
        $sql .= "    SELECT * FROM `c4isr_aliases_0`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_1`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_2`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_3`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_4`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_5`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_6`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_7`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_8`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_9`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_a`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_b`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_c`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_d`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_e`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_f`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_g`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_h`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_i`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_j`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_k`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_l`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_m`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_n`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_o`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_p`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_q`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_r`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_s`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_t`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_u`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_v`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_w`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_x`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_y`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_z`";
        $sql .= ") AS all_mails ";
        $sql .= !empty($patron) ? "WHERE `user` LIKE '%{$patron}%'" : "";
        $sql .= "LIMIT {$offset},{$limit};";
        $query = $this->db->query($sql);
        //echo($sql);
        return ($query->getResultArray());
    }

    public function query_UnionAlias($alias)
    {
        $sql = "SELECT * FROM (";
        $sql .= "    SELECT * FROM `c4isr_aliases_0`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_1`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_2`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_3`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_4`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_5`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_6`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_7`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_8`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_9`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_a`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_b`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_c`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_d`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_e`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_f`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_g`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_h`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_i`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_j`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_k`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_l`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_m`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_n`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_o`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_p`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_q`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_r`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_s`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_t`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_u`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_v`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_w`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_x`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_y`";
        $sql .= "    UNION ALL SELECT * FROM `c4isr_aliases_z`";
        $sql .= ") AS all_mails ";
        $sql .= "WHERE `alias`='{$alias}'";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        //echo($sql);
        return ($result[0]);
    }


    public function get_TotalUnion($patron)
    {
        $alfabeto = range('a', 'z');
        $numbers = range(0, 9);

        $sql = "SELECT COUNT(*) AS total FROM (";
        foreach ($alfabeto as $letra) {
            $sql .= "    SELECT * FROM `c4isr_aliases_{$letra}`";
            $sql .= "    UNION ALL ";
        }
        $sql = rtrim($sql, " UNION ALL ");
        $sql .= ") AS all_mails ";
        $sql .= !empty($patron) ? "WHERE `user` LIKE '%{$patron}%'" : "";
        $query = $this->db->query($sql);
        return ($query->getRow())->total;
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