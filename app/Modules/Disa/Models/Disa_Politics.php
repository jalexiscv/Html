<?php

namespace App\Modules\Disa\Models;

use Higgs\Model;

class Disa_Politics extends Model
{

    protected $table = "disa_politics";
    protected $primaryKey = "politic";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "dimension",
        "politic",
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
    protected $DBGroup = "authentication"; //default

    /**
     * Retorna el puntaje de una categoria, para ello priero lista todas las
     * actividades de la categoria, y luego suma sus puntajes promediando el
     * resultado.
     * @param type $year
     * @param type $month
     */
    public function get_ScoreByPolitic($politic)
    {
        $mdiagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $diagnostics = $mdiagnostics->get_ListByPolitic($politic);
        if (is_array($diagnostics)) {
            $count = count($diagnostics);
            $sum = 0;
            foreach ($diagnostics as $c) {
                $score = $mdiagnostics->get_ScoreByDiagnostic($c["diagnostic"]);
                $sum += $score;
            }
            if ($count > 0) {
                return (round($sum / $count, 2));
            }
        } else {
            return (0);
        }
    }

    /**
     * Retorna el puntaje de una categoria, para ello priero lista todas las
     * actividades de la categoria, y luego suma sus puntajes promediando el
     * resultado.
     * @param type $year
     * @param type $month
     */
    public function get_ScoreByPoliticX($politic)
    {
        $mdiagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
        $diagnostics = $mdiagnostics->get_ListByPolitic($politic);
        if (is_array($diagnostics)) {
            $count = count($diagnostics);
            $sum = 0;
            foreach ($diagnostics as $c) {
                $score = $mdiagnostics->get_ScoreByDiagnostic($c["diagnostic"]);
                $sum += $score;
            }
            return (round($sum / $count, 2));
        } else {
            return (0);
        }
    }

    /**
     * Retorna conteo de categorias existentes en un componente
     * un mes de un año especifico.
     * @param type $year
     * @param type $month
     */
    public function get_CountByDimension($dimension)
    {
        $sql = "SELECT COUNT(*) as `count` FROM `{$this->table}` WHERE(`deleted_at` IS NULL AND `dimension`='{$dimension}');";
        $query = $this->db->query($sql);
        $result = $query->getRowArray();
        if (isset($result["count"])) {
            return ($result["count"]);
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

    public function get_ListByDimension($dimension)
    {
        $result = $this->where("dimension", $dimension)->orderBy("order", "ASC")->findAll();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    public function get_ListByDimensionOLD($dimension)
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE (`deleted_at` IS NULL AND `dimension`='{$dimension}') ORDER BY `order` ASC;";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    /**
     * Retorna el listado de elementos existentes de forma que se pueda cargar un field tipo select.
     */
    public function get_SelectData($dimension)
    {
        $result = $this
            ->select("`{$this->primaryKey}` AS `value`,`name` AS `label`")
            ->where("dimension", $dimension)
            ->orderBy("name", "DESC")
            ->findAll();
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
        $row = $this->where("author", $id)->first();
        if (@$row["author"] == $author) {
            return (true);
        } else {
            return (false);
        }
    }

}

?>
