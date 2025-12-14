<?php

namespace App\Models;

class Application_Regions extends CachedModel
{

    protected $table = "application_regions";
    protected $primaryKey = "region";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "region",
        "country",
        "name",
        "date",
        "time",
        "author",
        "created_at",
        "updated_at",
        "deleted_at"];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "default";

    /**
     * Retorna el listado de elementos existentes
     * en un formato comprencible para un campo tipo select
     * @param type $year
     * @param type $month
     */
    public function get_SelectData($country)
    {
        $sql = ""
            . "SELECT `region` AS `value`,`name` AS `label` "
            . "FROM `{$this->table}` "
            . "WHERE("
            . "   `country`='{$country}' AND "
            . "   `deleted_at` IS NULL)"
            . "ORDER BY `name` ASC;";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }


    public function get_Region($region): false|array
    {
        $row = $this->find($region);
        if (is_array($row)) {
            return ($row);
        } else {
            return (false);
        }
    }

    public function getRegion($region): false|array {
        $cache_key = "region_" . md5($region);
        // Intentar obtener del caché
        if ($cached = cache($cache_key)) {
            return $cached;
        }
        $result = $this->find($region);
        if (is_array($result)) {
            // Guardar en caché por 24 horas (86400 segundos)
            cache()->save($cache_key, $result, 86400);
            return $result;
        }
        return false;
    }



}

?>