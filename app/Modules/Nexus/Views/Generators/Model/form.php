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
$code .= "\n";
$code .= "namespace App\\Modules\\{$ucf_module}\\Models;\n";
$code .= "\n";
$code .= "use Higgs\\Model;\n";
$code .= "use Config\\Database;\n";
$code .= "\n";
$code .= "class {$classname} extends Model\n";
$code .= "{\n";
$code .= "protected \$table = \"{$oid}\";\n";
$code .= "protected \$primaryKey = \"{$fields["0"]}\";\n";
$code .= "protected \$returnType = \"array\";\n";
$code .= "protected \$useSoftDeletes = true;\n";
$code .= "protected \$allowedFields = [\n";
foreach ($fields as $field) {
    $code .= "\t       \"{$field}\",\n";
}
$code .= "];\n";
$code .= "protected \$beforeFind = ['_exec_beforeFind'];\n";
$code .= "protected \$afterFind = ['_exec_findCache'];\n";
$code .= "protected \$afterInsert = ['_exec_updateCache'];\n";
$code .= "protected \$afterUpdate = ['_exec_updateCache'];\n";
$code .= "protected \$afterDelete = ['_exec_deleteCache'];\n";
$code .= "\n";
$code .= "protected \$useTimestamps = true;\n";
$code .= "protected \$createdField = \"created_at\";\n";
$code .= "protected \$updatedField = \"updated_at\";\n";
$code .= "protected \$deletedField = \"deleted_at\";\n";
$code .= "protected \$validationRules = [];\n";
$code .= "protected \$validationMessages = [];\n";
$code .= "protected \$skipValidation = false;\n";
$code .= "protected \$DBGroup = \"authentication\";//default\n";
$code .= "protected \$version = '1.0.0';\n";
$code .= "protected \$cache_time = 60;\n";
$code .= "protected \$cache;\n";
$code .= "\n";
$code .= "/**\n";
$code .= "* Inicializa el modelo y la regeneración de la tabla asociada si esta no existe\n";
$code .= "**/\n";
$code .= "public function __construct()\n";
$code .= "{\n";
$code .= "parent::__construct();\n";
$code .= "\$this->regenerate();\n";
$code .= "}\n";
$code .= "\n";
$code .= "/**\n";
$code .= "* Regenera o recrea la tabla de la base de datos en caso de que esta no exista\n";
$code .= "* Ejemplo de campos\n";
$code .= "* \$fields = [\n";
$code .= "*      'id'=> ['type'=>'INT','constraint'=> 5,'unsigned'=> true,'auto_increment' => true],\n";
$code .= "*      'title'=>['type'=> 'VARCHAR','constraint'=>'100','unique'  => true,],\n";
$code .= "*      'author'=>['type'=>'VARCHAR','constraint'=> 100,'default'=> 'King of Town',],\n";
$code .= "*      'description'=>['type'=>'TEXT','null'=>true,],\n";
$code .= "*      'status'=>['type'=>'ENUM','constraint'=>['publish','pending','draft'],'default'=>'pending',],\n";
$code .= "*   ];\n";
$code .= "*/\n";
$code .= "public function regenerate()\n";
$code .= "{\n";
$code .= "if (!\$this->tableExists()) {\n";
$code .= "\$forge = Database::forge(\$this->DBGroup);\n";
$code .= "\$fields = [\n";
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
$code .= "'author' => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => FALSE],\n";
$code .= "'created_at' => ['type' => 'DATETIME', 'null' => TRUE],\n";
$code .= "'updated_at' => ['type' => 'DATETIME', 'null' => TRUE],\n";
$code .= "'deleted_at' => ['type' => 'DATETIME', 'null' => TRUE],\n";
$code .= "];\n";
$code .= "\$forge->addField(\$fields);\n";
$code .= "\$forge->addPrimaryKey(\$this->primaryKey);\n";
$code .= "//\$forge->addKey('post');\n";
$code .= "//\$forge->addKey('profile');\n";
$code .= "\$forge->addKey('author');\n";
$code .= "\$forge->createTable(\$this->table, TRUE);\n";
$code .= "}\n";
$code .= "}\n";
$code .= "\n";
$code .= "/**\n";
$code .= "* Este método verifica si la tabla especificada existe en la base de datos utilizando la función tableExists()\n";
$code .= "* del objeto db de CodeIgniter. Además, utiliza la caché para almacenar el resultado de la verificación para mejorar\n";
$code .= "* el rendimiento y evitar la sobrecarga de la base de datos. La clave de caché se crea utilizando el método\n";
$code .= "* get_CacheKey(), que se supone que retorna una clave única para la tabla especificada. El tiempo de duración de\n";
$code .= "* la caché se establece en el atributo \$cache_time.\n";
$code .= "* @param \$tableName\n";
$code .= "* @return \Higgs\Cache\CacheInterface|bool|mixed\n";
$code .= "*/\n";
$code .= "private function tableExists()\n";
$code .= "{\n";
$code .= "\$cache_key = \$this->get_CacheKey(\$this->table);\n";
$code .= "if (!\$data = cache(\$cache_key)) {\n";
$code .= "\$data = \$this->db->tableExists(\$this->table);\n";
$code .= "cache()->save(\$cache_key, \$data, \$this->cache_time);\n";
$code .= "}\n";
$code .= "return \$data;\n";
$code .= "}\n";
$code .= "\n";
$code .= "/**\n";
$code .= "* Obtiene la clave de caché para un identificador dado.\n";
$code .= "* @param mixed \$id Identificador único para el objeto en caché.\n";
$code .= "* @return string Clave de caché generada para el identificador.\n";
$code .= "**/\n";
$code .= "protected function get_CacheKey(\$id)\n";
$code .= "{\n";
$code .= "\$node = APPNODE;\n";
$code .= "\$table = \$this->table;\n";
$code .= "\$class = urlencode(get_class(\$this));\n";
$code .= "\$version = \$this->version;\n";
$code .= "\$key = \"{\$node}-{\$table}-{\$class}-{\$version}-{\$id}\";\n";
$code .= "return md5(\$key);\n";
$code .= "}\n";
$code .= "\n";

$code .= "protected function _exec_findCache(array \$data)\n";
$code .= "{\n";
$code .= "\$id = \$data['id'] ?? null;\n";
$code .= "cache()->save(\$this->get_CacheKey(\$id), \$data['data'], \$this->cache_time);\n";
$code .= "return (\$data);\n";
$code .= "}\n";

$code .= "/**\n";
$code .= "* Obtiene una lista de registros combinados de cadastre_customers y cadastre_profiles\n";
$code .= "* con opciones de filtrado y paginación.\n";
$code .= "* @param int \$limit El número máximo de registros a obtener por página.\n";
$code .= "* @param int \$offset El número de registros a omitir antes de comenzar a seleccionar.\n";
$code .= "* @param string \$search (Opcional) El término de búsqueda para filtrar resultados.\n";
$code .= "* @return array|false    Un arreglo de registros combinados o false si no se encuentran registros.\n";
$code .= "*/\n";
$code .= "\n";
$code .= "public function get_List(\$limit, \$offset, \$search = \"\")\n";
$code .= "{\n";
$code .= "\$result = \$this\n";
$code .= "->join('cadastre_profiles', 'cadastre_customers.customer = cadastre_profiles.customer')\n";
$code .= "->select('cadastre_customers.*, cadastre_profiles.*')\n";
$code .= "->groupStart()\n";
$code .= "->like(\"cadastre_customers.customer\", \"%{\$search}%\")\n";
$code .= "->orLike(\"cadastre_customers.registration\", \"%{\$search}%\")\n";
$code .= "->groupEnd()\n";
$code .= "->orderBy(\"cadastre_customers.registration\", \"DESC\")\n";
$code .= "->findAll(\$limit, \$offset);\n";
$code .= "if (is_array(\$result)) {\n";
$code .= "return \$result;\n";
$code .= "} else {\n";
$code .= "return false;\n";
$code .= "}\n";
$code .= "}\n";
$code .= "\n";
$code .= "public function get_CountAllResults(\$search = \"\")\n";
$code .= "{\n";
$code .= "if (!empty(\$search)) {\n";
$code .= "\$result = \$this\n";
$code .= "->join('cadastre_profiles', 'cadastre_customers.customer = cadastre_profiles.customer')\n";
$code .= "->select('cadastre_customers.*, cadastre_profiles.*')\n";
$code .= "->groupStart()\n";
$code .= "->like(\"cadastre_customers.customer\", \"%{\$search}%\")\n";
$code .= "->orLike(\"cadastre_customers.registration\", \"%{\$search}%\")\n";
$code .= "->groupEnd()\n";
$code .= "->orderBy(\"cadastre_customers.registration\", \"DESC\")\n";
$code .= "->countAllResults();\n";
$code .= "} else {\n";
$code .= "\$result = \$this\n";
$code .= "->join('cadastre_profiles', 'cadastre_customers.customer = cadastre_profiles.customer')\n";
$code .= "->select('cadastre_customers.*, cadastre_profiles.*')\n";
$code .= "->orderBy(\"cadastre_customers.registration\", \"DESC\")\n";
$code .= "->countAllResults();\n";
$code .= "}\n";
$code .= "return (\$result);\n";
$code .= "}\n";
$code .= "\n";
$code .= "/**\n";
$code .= "* Retorna falso o verdadero si el usuario activo ne la sesión es el\n";
$code .= "* autor del regsitro que se desea acceder, editar o eliminar.\n";
$code .= "* @param type \$id codigo primario del registro a consultar\n";
$code .= "* @param type \$author codigo del usuario del cual se pretende establecer la autoria\n";
$code .= "* @return boolean falso o verdadero segun sea el caso\n";
$code .= "*/\n";
$code .= "public function get_Authority(\$id, \$author)\n";
$code .= "{\n";
$code .= "\$key = \$this->get_CacheKey(\"{\$id}{\$author}\");\n";
$code .= "\$cache = cache(\$key);\n";
$code .= "if (!\$this->is_CacheValid(\$cache)) {\n";
$code .= "\$row = \$this->where(\$this->primaryKey, \$id)->first();\n";
$code .= "if (isset(\$row[\"author\"]) && \$row[\"author\"] == \$author) {\n";
$code .= "\$value = true;\n";
$code .= "} else {\n";
$code .= "\$value = false;\n";
$code .= "}\n";
$code .= "\$cache = array('value' => \$value, 'retrieved' => true);\n";
$code .= "cache()->save(\$key, \$cache, \$this->cache_time);\n";
$code .= "}\n";
$code .= "return (\$cache['value']);\n";
$code .= "}\n";
$code .= "\n";
$code .= "/**\n";
$code .= "* Método is_CacheValid\n";
$code .= "* Este método verifica si los datos recuperados de la caché son válidos.\n";
$code .= "* @param mixed \$cache - Los datos recuperados de la caché.\n";
$code .= "* @return bool - Devuelve true si los datos de la caché son válidos, false en caso contrario.\n";
$code .= "*/\n";
$code .= "private function is_CacheValid(\$cache): bool\n";
$code .= "{\n";
$code .= "return is_array(\$cache) && array_key_exists('retrieved', \$cache) && \$cache['retrieved'] === true;\n";
$code .= "}\n";
$code .= "\n";
$code .= "/**\n";
$code .= "* Retorna el listado de elementos existentes de forma que se pueda cargar un field tipo select.\n";
$code .= "*/\n";
$code .= "public function get_SelectData()\n";
$code .= "{\n";
$code .= "\$result = \$this->select(\"`{\$this->primaryKey}` AS `value`,`name` AS `label`\")->findAll();\n";
$code .= "if (is_array(\$result)) {\n";
$code .= "return (\$result);\n";
$code .= "} else {\n";
$code .= "return (false);\n";
$code .= "}\n";
$code .= "}\n";
$code .= "\n";
$code .= "protected function _exec_beforeFind(array \$data)\n";
$code .= "{\n";
$code .= "if (isset(\$data['id']) && \$item = \$this->get_CachedItem(\$data['id'])) {\n";
$code .= "\$data['data'] = \$item;\n";
$code .= "\$data['returnData'] = true;\n";
$code .= "return \$data;\n";
$code .= "}\n";
$code .= "}\n";
$code .= "\n";
$code .= "\n";
$code .= "private function get_CachedItem(\$id)\n";
$code .= "{\n";
$code .= "\$cacheKey = \$this->get_CacheKey(\$id);\n";
$code .= "\$cachedData = cache(\$cacheKey);\n";
$code .= "return \$cachedData !== null ? \$cachedData : false;\n";
$code .= "}\n";
$code .= "\n";
$code .= "/**\n";
$code .= "* Implementa la lógica para actualizar la caché después de insertar o actualizar\n";
$code .= "* Por ejemplo, puedes utilizar la misma lógica que en exec_beforeFind\n";
$code .= "* y guardar los datos en la caché usando cache().\n";
$code .= "* @param array \$data\n";
$code .= "* @return void\n";
$code .= "*/\n";
$code .= "\n";
$code .= "protected function _exec_updateCache(array \$data)\n";
$code .= "{\n";
$code .= "\$id = \$data['id'] ?? null;\n";
$code .= "if (\$id !== null) {\n";
$code .= "\$updatedData = \$this->find(\$id);\n";
$code .= "if (\$updatedData) {\n";
$code .= "cache()->save(\$this->get_CacheKey(\$id), \$updatedData, \$this->cache_time);\n";
$code .= "}\n";
$code .= "}\n";
$code .= "}\n";
$code .= "\n";
$code .= "\n";
$code .= "/**\n";
$code .= "* Implementa la lógica para eliminar la caché después de eliminar\n";
$code .= "* Por ejemplo, puedes utilizar la misma lógica que en exec_beforeFind\n";
$code .= "* para invalidar la caché.\n";
$code .= "* @param array \$data\n";
$code .= "* @return void\n";
$code .= "*/\n";
$code .= "protected function _exec_deleteCache(array \$data)\n";
$code .= "{\n";
$code .= "\$id = \$data['id'] ?? null;\n";
$code .= "if (\$id !== null) {\n";
$code .= "\$deletedData = \$this->find(\$id);\n";
$code .= "if (\$deletedData) {\n";
$code .= "cache()->delete(\$this->get_CacheKey(\$id));\n";
$code .= "}\n";
$code .= "}\n";
$code .= "}\n";
$code .= "\n";
$code .= "\n";
$code .= "}\n";
$code .= "\n";
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