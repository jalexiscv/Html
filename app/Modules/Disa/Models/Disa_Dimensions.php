<?php

namespace App\Modules\Disa\Models;

use Higgs\Model;

class Disa_Dimensions extends Model
{

    protected $table = "disa_dimensions";
    protected $primaryKey = "dimension";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "dimension",
        "reference",
        "order",
        "name",
        "description",
        "process",
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
    public function get_ScoreByDimension($dimension)
    {
        $mpolitics = model("\App\Modules\Disa\Models\Disa_Politics", true);
        $politics = $mpolitics->get_ListByDimension($dimension);
        $count = count($politics);
        if (is_array($politics) && $count > 0) {
            $sum = 0;
            foreach ($politics as $c) {
                $score = $mpolitics->get_ScoreByPolitic($c["politic"]);
                $sum += $score;
            }
            return (round($sum / $count, 2));
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
    public function get_SelectData()
    {
        $result = $this
            ->select("`dimension` AS `value`,`name` AS `label`")
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

    /**
     * Retorna el listado de elementos existentes
     * un mes de un año especifico.
     * @param type $procedure servicio 1,2
     * @param type $year
     * @param type $month
     */
    public function get_List()
    {
        $result = $this->orderBy("order", "ASC")->findAll();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }

    }


}

?>