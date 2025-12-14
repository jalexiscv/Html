<?php

namespace App\Modules\Disa\Models;

use Higgs\Model;
use Config\Database;

class Disa_Components extends Model
{
    protected $table = "disa_components";
    protected $primaryKey = "component";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "component",
        "diagnostic",
        "order",
        "name",
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
        $forge = Database::forge($this->DBGroup);
        $fields = [
            'component' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'diagnostic' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'order' => ['type' => 'INT', 'constraint' => 10, 'null' => FALSE],
            'name' => ['type' => 'VARCHAR', 'constraint' => 254, 'null' => FALSE],
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
     * Retorna el promedio de los puntajes asociados a todas las actividades
     * contenpladas al interior de las categorias que corresponden al componente
     * seleccionado, este metodo se crea para igualar el resultado generado a la
     * forma en la cual se realiza en el excel.
     * @param type
     * @param type $month
     */
    public function get_ScoreByComponent($component)
    {
        $mcategories = model("\App\Modules\Disa\Models\Disa_Categories");
        $mactivities = model("\App\Modules\Disa\Models\Disa_Activities");
        $mscores = model("\App\Modules\Disa\Models\Disa_Scores");
        $categories = $mcategories->get_ListByComponent($component);
        if (is_array($categories)) {
            $count = count($categories);
            $sum = 0;
            foreach ($categories as $c) {
                $score = $mcategories->get_ScoreByCategory($c["category"]);
                $sum += $score;
            }
            if ($count > 0) {
                return (round($sum / $count, 2));
            } else {
                return (0);
            }
        } else {
            return (0);
        }
    }

    /**
     * Retorna el promedio de los puntajes asociados a las categorias que lo
     * conforman, desafortunadamente no es la forma en la cual hace el calculo
     * los diagnosticos en excel, por este moditvo se remplaza por una version
     * nueva, se conserva como referente y renombra de get_ScoreByComponent a
     * get_ScoreByComponentQualitative
     * actividades de la categoria, y luego suma sus puntajes promediando el
     * resultado.
     * @param type $year
     * @param type $month
     */
    public function get_ScoreByComponentQualitative($component)
    {
        $mcategories = model("\App\Modules\Disa\Models\Disa_Categories", true);
        $categories = $mcategories->get_ListByComponent($component);
        if (is_array($categories)) {
            $count = count($categories);
            $sum = 0;
            foreach ($categories as $c) {
                $score = $mcategories->get_ScoreByCategory($c["category"]);
                $sum += $score;
            }
            return (round($sum / $count, 2));
        } else {
            return (0);
        }
    }

    public function get_ListByDiagnostic($diagnostic)
    {
        $result = $this->where("diagnostic", $diagnostic)->orderBy("order", "ASC")->findAll();
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
    public function get_SelectData($diagnostic)
    {
        $result = $this->select("`{$this->primaryKey}` AS `value`,`name` AS `label`")
            ->where('diagnostic', $diagnostic)
            ->findAll();
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