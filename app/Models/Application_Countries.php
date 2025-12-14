<?php

namespace App\Models;

class Application_Countries extends CachedModel
{

    protected $table = "application_countries";
    protected $primaryKey = "country";
    protected $returnType = "array";
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        "country",
        "name",
        "_iso3",
        "codigo",
        "status",
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
    public function get_SelectData()
    {
        $result = $this->select("`{$this->primaryKey}` AS `value`,`name` AS `label`")->findAll();
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }

    public function get_Country($country)
    {
        $result = $this->find($country);
        if (is_array($result)) {
            return ($result);
        } else {
            return (false);
        }
    }


}

?>