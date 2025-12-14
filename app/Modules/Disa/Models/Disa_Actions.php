<?php

namespace App\Modules\Disa\Models;

use Higgs\Model;
use Config\Database;

class Disa_Actions extends Model
{

    protected $table = "disa_actions";
    protected $primaryKey = "action";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "action",
        "plan",
        "variables",
        "alternatives",
        "implementation",
        "evaluation",
        "percentage",
        "start",
        "end",
        "owner",
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
    protected $DBGroup = "authentication"; //default

    /**
     * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe
     * */
    public function __construct()
    {
        parent::__construct();
        $this->regenerate();
    }

    /**
     * Regenera o recrea la tabla de la base de datos en caso de que esta no exista
     * un mes de un año especifico.
     * @param type $year
     * @param type $month
     */
    public function regenerate()
    {
        $forge = Database::forge($this->DBGroup);
        $fields = [
            'action' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'plan' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'variables' => ['type' => 'TEXT', 'null' => TRUE],
            'alternatives' => ['type' => 'TEXT', 'null' => TRUE],
            'implementation' => ['type' => 'TEXT', 'null' => TRUE],
            'evaluation' => ['type' => 'TEXT', 'null' => TRUE],
            'percentage' => ['type' => 'DOUBLE', 'constraint' => 0.0, 'null' => TRUE],
            'start' => ['type' => 'DATE', 'null' => FALSE],
            'end' => ['type' => 'DATE', 'null' => FALSE],
            'owner' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => TRUE],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => TRUE],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => TRUE],
            'deleted_at' => ['type' => 'TIMESTAMP', 'null' => TRUE]];
        $forge->addField($fields);
        $forge->addPrimaryKey($this->primaryKey);
        $forge->addKey('plan');
        $forge->addKey('owner');
        $forge->addKey('author');
        $forge->createTable($this->table, TRUE);
    }

    /**
     * Retorna el conteo de acciones por un plan indicado.
     * un mes de un año especifico.
     * @param type $year
     * @param type $month
     */
    public function get_CountByPlan($plan)
    {
        $result = $this->where("plan", $plan)->countAllResults();
        return ($result);
    }

    /**
     * Retorna el listado de elementos existentes
     * un mes de un año especifico.
     * @param type $year
     * @param type $month
     */
    public function get_ListByPlan($plan)
    {
        $result = $this->where("plan", $plan)->find();
        if (is_array($result)) {
            return ($result);
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
