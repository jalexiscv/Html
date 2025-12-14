<?php

namespace App\Modules\Disa\Models;

use Higgs\Model;
use Config\Database;

class Disa_Causes_Scores extends Model
{

    protected $table = "disa_causes_scores";
    protected $primaryKey = "score";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "score",
        "cause",
        "value",
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
            'score' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'cause' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'value' => ['type' => 'DOUBLE', 'default' => 0.0, 'null' => FALSE],
            'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => TRUE],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => TRUE],
            'deleted_at' => ['type' => 'TIMESTAMP', 'null' => TRUE]
        ];
        $forge->addField($fields);
        $forge->addPrimaryKey($this->primaryKey);
        $forge->addKey('cause');
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
