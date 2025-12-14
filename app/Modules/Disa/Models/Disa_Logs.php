<?php

namespace App\Modules\History\Models;

use Higgs\Model;
use Config\Database;

class Logs extends Model
{
    protected $table = "history_logs";
    protected $primaryKey = "log";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "log",
        "module",
        "author",
        "description",
        "code",
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
            'log' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'module' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],
            'description' => ['type' => 'TEXT', 'null' => FALSE],
            'code' => ['type' => 'TEXT', 'null' => FALSE],
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
}

?>