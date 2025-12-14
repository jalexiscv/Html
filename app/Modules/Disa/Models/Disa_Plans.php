<?php

namespace App\Modules\Disa\Models;

use Higgs\Model;
use Config\Database;

class Disa_Plans extends Model
{

    protected $table = "disa_plans";
    protected $primaryKey = "plan";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "plan",
        "plan_institutional",
        "activity",
        "order",
        "description",
        "formulation",
        "evaluation",
        "value",
        "start",
        "end",
        "manager",
        "manager_subprocess",
        "manager_position",
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
     * Inicializa el modelo
     */
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
            'plan' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'plan_institutional' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'activity' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'manager' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'order' => ['type' => 'INT', 'constraint' => 3, 'null' => FALSE],
            'value' => ['type' => 'DOUBLE', 'null' => FALSE],
            'description' => ['type' => 'TEXT', 'null' => TRUE],
            'formulation' => ['type' => 'TEXT', 'null' => TRUE],
            'start' => ['type' => 'DATE', 'null' => FALSE],
            'end' => ['type' => 'DATE', 'null' => FALSE],
            'evaluation' => ['type' => 'DATE', 'null' => FALSE],
            'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => TRUE],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => TRUE],
            'deleted_at' => ['type' => 'TIMESTAMP', 'null' => TRUE],
        ];
        $forge->addField($fields);
        $forge->addPrimaryKey($this->primaryKey);
        $forge->addKey('activity');
        $forge->addKey('author');
        $forge->createTable($this->table, TRUE);
    }

    /**
     * Retorna el numero consecutivo asignable al nuevo plan de una actividad
     * especificada este numero debe ser un numero consecutivo mayor en uno al
     * mayor consecutivo existente, por la categoria consultada.
     * @param type $activity
     * @return type
     */
    public function get_ConsecutiveByActivity($activity)
    {
        $result = $this->where('activity', $activity)->orderBy('order', 'DESC')->first();
        if (isset($result["order"])) {
            return ($result["order"] + 1);
        } else {
            return (1);
        }
    }

    public function get_Consecutive($activity)
    {
        $result = $this->orderBy('order', 'DESC')->first();
        if (isset($result["order"])) {
            return ($result["order"] + 1);
        } else {
            return (1);
        }
    }

    /**
     * Retorna el conteo de planes existentes por una actividad,
     * @param type $activity
     * @return type
     */
    public function get_CountByActivity($activity)
    {
        $sql = "SELECT COUNT(*) as `count` FROM `{$this->table}` WHERE(`deleted_at` IS NULL AND `activity`='{$activity}');";
        $query = $this->db->query($sql);
        $result = $query->getRowArray();
        if (isset($result["count"])) {
            return ($result["count"]);
        } else {
            return (0);
        }
    }

    /**
     * Retorna el listado de planes asociado a una actividad especifica.
     * @param type $cid
     * @return type
     */
    public function get_ListByActivity($activity)
    {
        $result = $this
            ->where('activity', $activity)
            ->orderBy('order', 'DESC')
            ->findAll();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     * Retorna el listado de planes pendientes de realizar.
     * @param type $cid
     * @return type
     */
    public function get_ListPendingByActivity($activity)
    {
        $plans = $this->select('plan,activity,order')->where('activity', $activity)->orderBy('order', 'DESC')->findAll();
        if (is_array($plans)) {
            $mds = model("\App\Modules\Disa\Models\Disa_Statuses", true);
            $count = 0;
            foreach ($plans as $plan) {
                $status = $mds->get_Status($plan['plan']);
                if ($status == false || $status["value"] != 'COMPLETED') {
                    $count++;
                }
            }
            return ($count);
        } else {
            return (0);
        }
    }

    /**
     * Retorna el listado de plabes ejecutados en su totalidad por actividad
     * @param type $cid
     * @return type
     */
    public function get_ListMadesByActivity($activity)
    {
        $plans = $this->select('plan,activity,order')->where('activity', $activity)->orderBy('order', 'DESC')->findAll();
        if (is_array($plans)) {
            $mds = model("\App\Modules\Disa\Models\Disa_Statuses", true);
            $count = 0;
            foreach ($plans as $plan) {
                $status = $mds->get_Status($plan['plan']);
                if (is_array($status)) {
                    if (isset($status['value']) && $status['value'] == 'COMPLETED') {
                        $count++;
                    }
                }
            }
            return ($count);
        } else {
            return (0);
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
        $sql = "SELECT `service` AS `value`,`name` AS `label` FROM `{$this->table}` ORDER BY `service` ASC;";
        //$sql = "SELECT *, `reference` AS `value`,CONCAT_WS(': ', `reference`, `name`) AS `label` FROM `{$this->table}` ORDER BY `reference` ASC;";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

}

?>
