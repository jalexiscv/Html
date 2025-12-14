<?php

/*
* -----------------------------------------------------------------------------
* [code]
* -----------------------------------------------------------------------------
*/

use Config\Database;

$action = "";

$f = service("forms", array("lang" => "Nexus."));
/** request * */
$r["client"] = $f->get_Value("client", strtoupper(uniqid()));
$r["time"] = $f->get_Value("time", service("dates")::get_Time());

$eid = explode("_", $oid);
$ucf_module = safe_ucfirst($eid[0]);
$ucf_component = safe_ucfirst($eid[1]);
$ucf_options = safe_ucfirst(@$eid[2]);
$slc_module = safe_strtolower($eid[0]);
$slc_component = safe_strtolower($eid[1]);
$slc_options = safe_strtolower(@$eid[2]);

if (count($eid) == 3) {
    $classname = "{$ucf_module}_{$ucf_component}_{$ucf_options}";
} else {
    $classname = "{$ucf_module}_{$ucf_component}";
}
$mkdir = APPPATH . "Modules/{$ucf_module}/Models";
$pathfile = APPPATH . "Modules/{$ucf_module}/Models/_{$classname}.php";
$relative = "Modules/{$ucf_module}/Models/_{$classname}.php";

$db = Database::connect("default");
$fields = $db->getFieldNames($oid);
$datas = $db->getFieldData($oid);

$code = "";
$code .= "<?php\n";
$code .= "namespace App\\Modules\\{$ucf_module}\\Models;\n";
$code .= "use Higgs\\Model;\n";
$code .= "use Config\Database;\n";
$code .= "class {$classname} extends Model {\n";
$code .= "   protected \$table = \"{$oid}\";\n";
$code .= "   protected \$primaryKey = \"{$fields["0"]}\";\n";
$code .= "   protected \$returnType = \"array\";\n";
$code .= "   protected \$useSoftDeletes = true;\n";
$code .= "   protected \$allowedFields = [\n";
foreach ($fields as $field) {
    $code .= "\t       \"{$field}\",\n";
}
$code .= "       ];\n";
$code .= "   protected \$useTimestamps = true;\n";
$code .= "   protected \$createdField = \"created_at\";\n";
$code .= "   protected \$updatedField = \"updated_at\";\n";
$code .= "   protected \$deletedField = \"deleted_at\";\n";
$code .= "   protected \$validationRules = [];\n";
$code .= "   protected \$validationMessages = [];\n";
$code .= "   protected \$skipValidation = false;\n";
$code .= "   protected \$DBGroup=\"authentication\";//default\n";
$code .= "   protected \$version='1.0.0';\n";
$code .= "   protected \$cache_time=60;\n";


$code .= "   /**\n";
$code .= "   * Inicializa el modelo y la regeneración de la tabla asociada si esta no existe\n";
$code .= "   **/";
$code .= "       public function __construct() {\n";
$code .= "           parent::__construct();\n";
$code .= "           \$this->regenerate();\n";
$code .= "       }\n";

$code .= "   /**\n";
$code .= "   * Retorna el listado de elementos existentes\n";
$code .= "   * un mes de un año especifico.\n";
$code .= "   * @param type \$year\n";
$code .= "   * @param type \$month\n";
$code .= "   */";
$code .= "   public function get_List() {\n";
$code .= "      \$sql = \"SELECT * FROM `{\$this->table}` ORDER BY `reference` ASC;\";\n";
$code .= "      \$query = \$this->db->query(\$sql);\n";
$code .= "      \$result = \$query->getResultArray();\n";
$code .= "      if (is_array(\$result)) {\n";
$code .= "          return(\$result);\n";
$code .= "      } else {\n";
$code .= "          return(false);\n";
$code .= "      }\n";
$code .= "   }\n";

$code .= "    /**\n";
$code .= "    * Retorna falso o verdadero si el usuario activo ne la sesión es el \n";
$code .= "    * autor del regsitro que se desea acceder, editar o eliminar.\n";
$code .= "    * @param type \$id codigo primario del registro a consultar\n";
$code .= "    * @param type \$author codigo del usuario del cual se pretende establecer la autoria\n";
$code .= "    * @return boolean falso o verdadero segun sea el caso\n";
$code .= "    */\n";
$code .= "    public function get_Authority(\$id, \$author)\n";
$code .= "    {\n";
$code .= "        \$key = \$this->get_CacheKey(\"{\$id}{\$author}\");\n";
$code .= "        \$cache = cache(\$key);\n";
$code .= "        if (!\$this->is_CacheValid(\$cache)) {\n";
$code .= "            \$row = \$this->where(\$this->primaryKey, \$id)->first();\n";
$code .= "            if (isset(\$row[\"author\"]) && \$row[\"author\"] == \$author) {\n";
$code .= "                \$value = true;\n";
$code .= "            } else {\n";
$code .= "                \$value = false;\n";
$code .= "            }\n";
$code .= "            \$cache = array('value' => \$value, 'retrieved' => true);\n";
$code .= "            cache()->save(\$key, \$cache, \$this->cache_time);\n";
$code .= "        }\n";
$code .= "        return (\$cache['value']);\n";
$code .= "    }\n";

$code .= "/**\n";
$code .= "* Retorna el listado de elementos existentes de forma que se pueda cargar un field tipo select.\n";
$code .= "*/\n ";
$code .= "    public function get_SelectData() {\n";
$code .= "        \$result=\$this->select(\"`{\$this->primaryKey}` AS `value`,`name` AS `label`\")->findAll();\n";
$code .= "        if (is_array(\$result)){\n";
$code .= "            return(\$result);\n";
$code .= "        } else {\n";
$code .= "            return(false);\n";
$code .= "       }\n";
$code .= "   }\n";


/** Cachin **/


$code .= "\t /**\n";
$code .= "\t  * Método is_CacheValid\n";
$code .= "\t  * Este método verifica si los datos recuperados de la caché son válidos.\n";
$code .= "\t  * @param mixed \$cache - Los datos recuperados de la caché.\n";
$code .= "\t  * @return bool - Devuelve true si los datos de la caché son válidos, false en caso contrario.\n";
$code .= "\t  */\n";
$code .= "\t private function is_CacheValid(\$cache): bool\n";
$code .= "\t {\n";
$code .= "\t     return is_array(\$cache) && array_key_exists('retrieved', \$cache) && \$cache['retrieved'] === true;\n";
$code .= "\t }\n";

$code .= "\t /**\n";
$code .= "\t  * Este método verifica si la tabla especificada existe en la base de datos utilizando la función tableExists()\n";
$code .= "\t  * del objeto db de CodeIgniter. Además, utiliza la caché para almacenar el resultado de la verificación para mejorar\n";
$code .= "\t  * el rendimiento y evitar la sobrecarga de la base de datos. La clave de caché se crea utilizando el método\n";
$code .= "\t  * get_CacheKey(), que se supone que retorna una clave única para la tabla especificada. El tiempo de duración de\n";
$code .= "\t  * la caché se establece en el atributo \$cache_time.\n";
$code .= "\t  * @param \$tableName\n";
$code .= "\t  * @return \Higgs\Cache\CacheInterface|bool|mixed\n";
$code .= "\t  */\n";
$code .= "\t private function tableExists()\n";
$code .= "\t  {\n";
$code .= "\t \$cache_key = \$this->get_CacheKey(\$this->table);";
$code .= "\t if (!\$data = cache(\$cache_key)) {\n";
$code .= "\t        \$data = \$this->db->tableExists(\$this->table);\n";
$code .= "\t        cache()->save(\$cache_key, \$data, \$this->cache_time * 10);\n";
$code .= "\t    }\n";
$code .= "\t    return (\$data);\n";
$code .= "\t }\n";

$code .= "\t /**\n";
$code .= "\t * Retorna resultados cacheados\n";
$code .= "\t */\n";
$code .= "    public function find(\$id = null)\n";
$code .= "    {\n";
$code .= "        \$key = \$this->get_CacheKey(\"{\$id}\");\n";
$code .= "        \$cache = cache(\$key);\n";
$code .= "        if (!\$this->is_CacheValid(\$cache)) {\n";
$code .= "            \$value = parent::find(\$id);\n";
$code .= "            \$cache = array('value' => \$value, 'retrieved' => true);\n";
$code .= "            cache()->save(\$key, \$cache, \$this->cache_time);\n";
$code .= "        }\n";
$code .= "        return (\$cache['value']);\n";
$code .= "    }\n";
$code .= "\n";

$code .= "\t /**\n";
$code .= "\t * Inserta un nuevo registo y actualiza el chache\n";
$code .= "\t */\n";
$code .= "public function insert(\$data = null, bool \$returnID = true)";
$code .= "\n{";
$code .= "\n\t \$result = parent::insert(\$data, \$returnID);";
$code .= "\n\t if (\$result === true || \$returnID && is_numeric(\$result)) {";
$code .= "\n\t\t \$cache_key = \$this->get_CacheKey(\$this->db->insertID());";
$code .= "\n\t\t \$data = parent::find(\$this->db->insertID());";
$code .= "\n\t\t cache()->save(\$cache_key, \$data, \$this->cache_time);";
$code .= "\n\t\t ";
$code .= "\n\t }";
$code .= "\n\t return(\$result);";
$code .= "\n}";
$code .= "\n";

$code .= "\t /**\n";
$code .= "\t * Actualiza un registo y actualiza el chache\n";
$code .= "\t */\n";
$code .= "public function update(\$id = null, \$data = null): bool";
$code .= "{";
$code .= "\$result = parent::update(\$id, \$data);";
$code .= "";
$code .= "if (\$result === true) {\n";
$code .= "  cache()->delete(\$this->get_CacheKey(\$id));\n";
$code .= "}";
$code .= "return (\$result);\n";
$code .= "}\n";
$code .= "\n";

$code .= "\t /**\n";
$code .= "\t * Elimina un registo y actualiza el chache\n";
$code .= "\t */\n";
$code .= "\tpublic function delete(\$id = null, \$purge = false)\n";
$code .= "\t{\n";
$code .= "\t\t\$result = parent::delete(\$id, \$purge);\n";
$code .= "\t\tif (\$result === true) {\n";
$code .= "\t\t\tcache()->delete(\$this->get_CacheKey(\$id));\n";
$code .= "\t\t}\n";
$code .= "\treturn (\$result);\n";
$code .= "\t}\n";
$code .= "\n";


$code .= "\t/**\n";
$code .= "\t * Obtiene la clave de caché para un identificador dado.\n";
$code .= "\t * @param mixed \$id Identificador único para el objeto en caché.\n";
$code .= "\t * @return string Clave de caché generada para el identificador.\n";
$code .= "\t **/\n";
$code .= "\t protected function get_CacheKey(\$id)\n";
$code .= "\t {\n";
$code .= "\t\t \$node = APPNODE;\n";
$code .= "\t\t \$table = \$this->table;\n";
$code .= "\t\t \$class = str_replace('\\\', '_', get_class(\$this));\n";
$code .= "\t\t \$version = \$this->version;\n";
$code .= "\t\t \$key = \"{\$node}-{\$table}-{\$class}-{\$version}-{\$id}\";\n";
$code .= "\t\t return(md5(\$key));\n";
$code .= "\t }\n";
$code .= "\n";

/** Regenerate **/
$code .= "\t /**\n";
$code .= "\t * Regenera o recrea la tabla de la base de datos en caso de que esta no exista\n";
$code .= "\t * Ejemplo de campos\n";
$code .= "\t * \$fields = [\n";
$code .= "\t *      'id'=> ['type'=>'INT','constraint'=> 5,'unsigned'=> true,'auto_increment' => true],\n";
$code .= "\t *      'title'=>['type'=> 'VARCHAR','constraint'=>'100','unique'  => true,],\n";
$code .= "\t *      'author'=>['type'=>'VARCHAR','constraint'=> 100,'default'=> 'King of Town',],\n";
$code .= "\t *      'description'=>['type'=>'TEXT','null'=>true,],\n";
$code .= "\t *      'status'=>['type'=>'ENUM','constraint'=>['publish','pending','draft'],'default'=>'pending',],\n";
$code .= "\t *   ];\n";
$code .= "\t */\n";
$code .= "\t public function regenerate(){\n";
$code .= "\t if (!\$this->tableExists()) {\n";
$code .= "\t\t \$forge = Database::forge(\$this->DBGroup);\n";
$code .= "\t\t \$fields = [\n";
foreach ($datas as $field) {
    if (($field->name != "author") && ($field->name != "created_at") && ($field->name != "updated_at") && ($field->name != "deleted_at")) {
        if ($field->type == "int") {
            $code .= "\t\t\t '{$field->name}' => ['type' => 'INT', 'constraint' =>10, 'null' => FALSE],\n";
        } elseif ($field->type == "double") {
            $code .= "\t\t\t '{$field->name}' => ['type' => 'DOUBLE','constraint' =>'10,2','default' => 0.00, 'null' => FALSE],\n";
        } elseif ($field->type == "varchar") {
            $code .= "\t\t\t '{$field->name}' => ['type' => 'VARCHAR','constraint' =>{$field->max_length}, 'null' => FALSE],\n";
        } else {
            $type = strtoupper($field->type);
            $code .= "\t\t\t '{$field->name}' => ['type' => '{$type}', 'null' => FALSE],\n";
        }
    }
}
$code .= "\t\t\t 'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],\n";
$code .= "\t\t\t 'created_at' => ['type' => 'DATETIME', 'null' => TRUE],\n";
$code .= "\t\t\t 'updated_at' => ['type' => 'DATETIME', 'null' => TRUE],\n";
$code .= "\t\t\t 'deleted_at' => ['type' => 'DATETIME', 'null' => TRUE],\n";
$code .= "        ];\n";
$code .= "        \$forge->addField(\$fields);\n";
$code .= "        \$forge->addPrimaryKey(\$this->primaryKey);\n";
$code .= "        //\$forge->addKey('post');\n";
$code .= "        //\$forge->addKey('profile');\n";
$code .= "        \$forge->addKey('author');\n";
$code .= "        \$forge->createTable(\$this->table, TRUE);\n";
$code .= "   }\n";
$code .= "   }\n";

$code .= "}\n";
$code .= "?>\n";
/*
 * -----------------------------------------------------------------------------
 * [Requests]
 * -----------------------------------------------------------------------------
 */
$r["uri_save"] = $f->get_Value("uri_save", $pathfile);
$r["code"] = $f->get_Value("code", $code);
$r["date"] = $f->get_Value("date", service("dates")::get_Date());
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
/*
 * -----------------------------------------------------------------------------
 * [Fields]
 * -----------------------------------------------------------------------------
 */
$f->add_HiddenField("pathfile", $pathfile);
$f->add_HiddenField("mkdir", $mkdir);
$f->add_HiddenField("relative", $relative);
$f->fields["uri_save"] = $f->get_FieldText("uri_save", array("value" => $r["uri_save"], "readonly" => true));
$f->fields["code"] = $f->get_FieldCode("code", array("value" => $r["code"], "mode" => "php"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/nexus/generators/", "text" => lang("App.Cancel"),
    "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
/*
 * -----------------------------------------------------------------------------
 * [Groups]
 * -----------------------------------------------------------------------------
 */
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["uri_save"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["code"])));
/*
 * -----------------------------------------------------------------------------
 * [Buttons]
 * -----------------------------------------------------------------------------
 */
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
/*
 * -----------------------------------------------------------------------------
 * [Build]
 * -----------------------------------------------------------------------------
 */
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", lang("Nexus.generators-model"));
$smarty->assign("body", $f);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));

?>