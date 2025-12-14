<?php

use Config\Database;

$action = "";
$module = "";
$component = "";
$f = service("forms", array("lang" => "Nexus."));
/** request * */
$r["client"] = $f->get_Value("client", strtoupper(uniqid()));
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
$id = $oid;
$eid = explode("_", $id);
$ucf_module = safe_ucfirst($eid[0]);
$ucf_component = safe_ucfirst($eid[1]);
$ucf_options = safe_ucfirst(@$eid[2]);
$slc_module = safe_strtolower($eid[0]);
$slc_component = safe_strtolower($eid[1]);
$slc_options = safe_strtolower(@$eid[2]);

if (count($eid) == 3) {
    $model = "App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}_{$ucf_options}";
    $path = '/' . $slc_module . '/' . $slc_component . '/' . $slc_options;
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\{$ucf_options}\\Editor\\index.php";
    $singular = "{$slc_module}-{$slc_component}-{$slc_options}-view";
    $plural = "{$slc_module}-{$slc_component}-{$slc_options}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/{$ucf_options}/View";
    $ajax = "/{$slc_module}/{$slc_component}/{$slc_options}/ajax/list?time=\".time()";
} else {
    $model = "App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}";
    $path = '/' . $slc_module . '/' . $slc_component;
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\Editor\\index.php";
    $singular = "{$slc_module}-{$slc_component}-view";
    $plural = "{$slc_module}-{$slc_component}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/View";
    $ajax = "/{$slc_module}/{$slc_component}/ajax/list/";
}

$db = Database::connect("default");
$fields = $db->getFieldNames($id);


$code = "<?php\n";
$code .= get_nexus_code_copyright(array("path" => $namespaced));
$code .= "/*\n";
$code .= "* -----------------------------------------------------------------------------\n";
$code .= "* [Vars]\n";
$code .= "* -----------------------------------------------------------------------------\n";
$code .= "*/\n";

$code .= "\$data = \$parent->get_Array();\n";
$code .= "\$data['model']=model(\"App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}\");\n";
$code .= "\$data['permissions'] = array('singular' => '{$singular}', \"plural\" =>'{$plural}');\n";
$code .= "\$singular = \$authentication->has_Permission(\$data['permissions']['singular']);\n";
$code .= "\$plural = \$authentication->has_Permission(\$data['permissions']['plural']);\n";
$code .= "\$author= \$data['model']->get_Authority(\$oid,safe_get_user());\n";
$code .= "\$authority= (\$singular&&\$author)?true:false;\n";
$code .= "\$submited = \$request->getPost(\"submited\");\n";
$code .= "\$header = \$component . '\breadcrumb';\n";
$code .= "\$validator = \$component . '\\validator';\n";
$code .= "\$form = \$component . '\\form';\n";
$code .= "\$deny = \$component . '\\deny';\n";
$code .= "/*\n";
$code .= "* -----------------------------------------------------------------------------\n";
$code .= "* [Evaluate]\n";
$code .= "* -----------------------------------------------------------------------------\n";
$code .= "*/\n";
$code .= "if(\$plural||\$authority) {\n";
$code .= "\t if (!empty(\$submited)) {\n";
$code .= "\t\t \$c = view(\$validator, \$data);\n";
$code .= "\t } else {\n";
$code .= "\t\t \$c = view(\$form, \$data);\n";
$code .= "\t }\n";
$code .= "} else {\n";
$code .= "\t \$c = view(\$deny, \$data);\n";
$code .= "}\n";
$code .= "/*\n";
$code .= "* -----------------------------------------------------------------------------\n";
$code .= "* [Build]\n";
$code .= "* -----------------------------------------------------------------------------\n";
$code .= "*/\n";
$code .= "session()->set('page_template','page');\n";
$code .= "session()->set('page_header',view(\$header,\$data));\n";;
$code .= "session()->set('main_template','c9c3');\n";
$code .= "session()->set('messenger',true);\n";
$code .= "session()->set('main',\$c);\n";
$code .= "session()->set('right','');\n";
$code .= "?>\n";

echo($code);
?>