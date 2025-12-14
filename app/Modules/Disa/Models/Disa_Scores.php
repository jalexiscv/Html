<?php

namespace App\Modules\Disa\Models;

use Higgs\Model;

class Disa_Scores extends Model
{

    protected $table = "disa_scores";
    protected $primaryKey = "score";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "score",
        "activity",
        "plan",
        "value",
        "details",
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
     * Retorna el listado de otdas las calificaciones de la actividad en orden
     * descendente desde la ultima registrada.
     * @param type $aid
     * @return type
     */
    public function get_ListByActivity($aid)
    {
        $result = $this
            ->where('activity', $aid)
            ->orderBy("created_at", "DESC")
            ->findAll();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     * Retorna el listado de otdas las calificaciones de la actividad en orden
     * descendente desde la ultima registrada.
     * @param type $aid
     * @return type
     */
    public function get_ScoreByActivity($activity)
    {
        $result = $this
            ->where('activity', $activity)
            ->orderBy("created_at", "DESC")
            ->first();
        if (is_array($result)) {
            return (round($result["value"], 2));
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
