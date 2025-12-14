<?php

namespace App\Modules\Disa\Models;

use Higgs\Model;

class Disa_Subprocesses extends Model
{

    protected $table = "disa_subprocesses";
    protected $primaryKey = "subprocess";
    protected $returnType = "array";
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        "subprocess",
        "process",
        "name",
        "description",
        "position",
        "responsible",
        "phone",
        "email",
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


    public function get_Name($pid)
    {
        $row = $this->where("subprocess", $pid)->first();
        if (is_array($row)) {
            return (urldecode($row["name"]));
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
        $sql = "SELECT `subprocess` AS `value`,`name` AS `label` FROM `{$this->table}` ORDER BY `name` ASC;";
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
