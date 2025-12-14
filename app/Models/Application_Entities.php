<?php

namespace App\Models;

use Config\Database;
use Higgs\Model;

class Application_Entities extends Model
{
    protected $table = "TABLES";
    protected $primaryKey = "TABLE_NAME";
    protected $returnType = "array";
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        "TABLE_CATALOG",
        "TABLE_SCHEMA",
        "TABLE_NAME",
        "TABLE_TYPE",
        "ENGINE",
        "VERSION",
        "ROW_FORMAT",
        "TABLE_ROWS",
        "AVG_ROW_LENGTH",
        "DATA_LENGTH",
        "MAX_DATA_LENGTH",
        "INDEX_LENGTH",
        "DATA_FREE",
        "AUTO_INCREMENT",
        "CREATE_TIME",
        "UPDATE_TIME",
        "CHECK_TIME",
        "TABLE_COLLATION",
        "CHECKSUM",
        "CREATE_OPTIONS",
        "TABLE_COMMENT",
    ];
    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $deletedField = "deleted_at";
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $DBGroup = "shema";

    /**
     * Retorna la estructura de una tabla en la base de datos
     * @param type $table
     * @return type
     */
    public function getStructure($table)
    {
        $fields = array();
        $query = $this->db->query("DESCRIBE `{$table}`");
        foreach ($query->result_array() as $row) {
            array_push($fields, $row);
        }
        return ($fields);
    }

    /**
     * Retorna una lista de objetos donde cada objeto corresponde a caracteristicas MySQL de
     * una tabla especifica. Este metodo fue creado teniendo en consideración una posible consulta
     * de criterio extendido que abarcara los datos almacenados como campos en la tabla
     * security_users_fields
     * @return type
     */
    public function getArrayList($search, $limit, $start)
    {
        $db_database = "anssible_anssible";
        $this->db->select("*");
        $this->db->from("`INFORMATION_SCHEMA`.`TABLES`");
        $this->db->where("TABLE_SCHEMA", "{$db_database}");
        if (!empty($search)) {
            $this->db->like("TABLE_NAME", $search);
        }
        $this->db->order_by("TABLE_NAME", "DESC");
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo($this->db->last_query());
        return ($query->result_array());
    }

//    public function getArrayList3($search, $limit, $start) {
//        $query = $this->db->query(""
//                . "SELECT * FROM  "
//                . "WHERE(`TABLE_SCHEMA`='MX_anssible' AND "
//                . "`TABLE_NAME` LIKE '%{$search}%') "
//                . "LIMIT {$limit},{$start};");
//        
//        $consulta = $this->db->get("`INFORMATION_SCHEMA`.`TABLES`");
//        $list = array();
//        foreach ($$consulta->result() as $row) {
//            $data["table"] = $row->TABLE_NAME;
//            $data["rows"] = $row->TABLE_ROWS;
//            array_push($list, $data);
//        }
//
//        return($list);
//    }

    public function get_List($search, $limit, $offset)
    {
        $query = $this
            ->where("TABLE_SCHEMA", "higgs-root")
            ->like("TABLE_NAME", $search)
            ->findAll($limit, $offset);
        return ($query);
    }



    /**
     * Retorna el numero total de registros existentes en la tabla
     * @param type $attr
     * @return type
     */
    public function getTotalCount($attr = array())
    {
        $query = $this->db->query("
        SELECT COUNT(*) AS `count`
        FROM `INFORMATION_SCHEMA`.`TABLES`
        WHERE `TABLE_SCHEMA` = 'higgs-root'
    ");
        $result = $query->getRowArray();
        return $result['count'];
    }

    /**
     * Retorna el numero total filtrados en la tabla
     * @param type $attr
     * @return type
     */
    public function getTotalCountFiltered($search = null)
    {
        if (!empty($this->db)) {
            $query = $this->db->query(""
                . "SELECT COUNT(*) AS `count`  FROM `INFORMATION_SCHEMA`.`TABLES` "
                . "WHERE(`TABLE_SCHEMA`='anssible_anssible' AND `TABLE_NAME` LIKE '%{$search}%'); "
                . "");
            $result = $query->objectToRawArray();
            return ($result["count"]);
        } else {
            return (0);
        }
    }

    /**
     * Este método verifica si la tabla especificada existe en la base de datos utilizando la función tableExists()
     * del objeto db de CodeIgniter. Además, utiliza la caché para almacenar el resultado de la verificación para mejorar
     * el rendimiento y evitar la sobrecarga de la base de datos. La clave de caché se crea utilizando el método
     * get_CacheKey(), que se supone que retorna una clave única para la tabla especificada. El tiempo de duración de
     * la caché se establece en el atributo $cache_time.
     * @param $tableName
     * @return \Higgs\Cache\CacheInterface|bool|mixed
     */
    private function tableExists($tableName)
    {
        $cache_key = '_table_exist_' . APPNODE . '_' . $this->table;
        if (!$data = cache($cache_key)) {
            $data = $this->db->tableExists($tableName);
            cache()->save($cache_key, $data, $this->cache_time * 10);
        }
        return ($data);
    }
}

?>