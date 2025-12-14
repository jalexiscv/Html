<?php

namespace App\Models;

class Application_Cities extends CachedModel
{

    protected $table = "application_towns";
    protected $primaryKey = "city";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "city",
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
    public function get_SelectData($region)
    {
        $sql = ""
            . "SELECT `city` AS `value`,`name` AS `label` "
            . "FROM `{$this->table}` "
            . "WHERE("
            . "   `region`='{$region}' AND "
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

    public function get_City($city): false|array
    {
        $result = $this->find($city);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Este metodo hace uso de "CachedModel" para almacenar los datos de una ciudad y servirlos como resultado,
     * si la ciudad no se encuentra en cache, se consulta la base de datos y se almacena en cache para futuras consultas
     * @param $city
     * @return false|array
     */
    public function get_CachedCity($city): false|array
    {
        $cacheKey = $this->get_CacheKey(['city' => $city]);
        $cachedData = $this->read_Cache($cacheKey);
        if ($cachedData === null) {
            $data = $this->find($city);
            if ($data !== null) {
                $this->save_Cache($cacheKey, $data);
            }
            return $data;
        }
        return ($cachedData);
    }


    public function getCity($city): false|array
    {
        $cache_key = "city_" . md5($city);
        if ($cached = cache($cache_key)) {
            return $cached;
        }
        $result = $this->find($city);
        if (is_array($result)) {
            cache()->save($cache_key, $result, 86400);
            return $result;
        }
        return(false);
    }


}

?>