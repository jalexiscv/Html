<?php
/*
 * Copyright (c) 2021-2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

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
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\{$ucf_options}\\Delete\\form.php";
    $plural = "{$slc_module}-{$slc_component}-{$slc_options}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/{$ucf_options}/Delete";
    $ajax = "/{$slc_module}/{$slc_component}/{$slc_options}/ajax/list?time=\".time()";
} else {
    $model = "App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}";
    $path = '/' . $slc_module . '/' . $slc_component;
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\Delete\\form.php";
    $plural = "{$slc_module}-{$slc_component}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/Delete";
    $ajax = "/{$slc_module}/{$slc_component}/ajax/list/";
}

$db = Database::connect("default");
$fields = $db->getFieldNames($id);

$code = "<?php\n";
$code .= get_nexus_code_copyright(array("path" => $namespaced));

$code .= COMMENT_HR_SERVICES;
$code .= "\$b = service(\"bootstrap\");\n";
$code .= COMMENT_HR_MODELS;
$code .= "//\$model = model(\"App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}\");\n";
$code .= COMMENT_HR_VARS;
$code .= "\$f = service(\"forms\", array(\"lang\" => \"{$ucf_component}.\"));\n";
$code .= "\$r = \$model->find(\$oid);\n";
$code .= "\$name = urldecode(\$r[\"name\"]);\n";
$code .= "\$message=sprintf(lang(\"{$ucf_module}.{$slc_component}-delete-message\"),\$name);\n";
$code .= "\$back=\"/{$slc_module}/{$slc_component}/list/\".lpk();\n";
$code .= COMMENT_HR_FIELDS;
$code .= "\$f->add_HiddenField(\"pkey\", \$oid);\n";
$code .= "\$f->fields[\"cancel\"] = \$f->get_Cancel(\"cancel\", array(\"href\" => \$back, \"text\" => lang(\"App.Cancel\"), \"type\" => \"secondary\", \"proportion\" => \"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right\"));\n";
$code .= "\$f->fields[\"submit\"] = \$f->get_Submit(\"submit\", array(\"value\" => lang(\"App.Delete\"), \"proportion\" => \"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left\"));\n";
$code .= COMMENT_HR_GROUPS;
$code .= "\$f->groups[\"gy\"] = \$f->get_GroupSeparator();\n";
$code .= COMMENT_HR_BUTTONS;
$code .= "\$f->groups[\"gz\"] = \$f->get_Buttons(array(\"fields\" => \$f->fields[\"submit\"] . \$f->fields[\"cancel\"]));\n";
$code .= COMMENT_HR_BUILD;
$code .= "\$card = \$b->get_Card(\"delete-{\$oid}\", array(\n";
$code .= "\t\t \"class\" =>\"card-info\",\n";
$code .= "\t\t \"icon\" => ICON_WARNING,\n";
$code .= "\t\t \"title\" => sprintf(lang(\"{$ucf_component}.delete-title\"),\$name),\n";
$code .= "\t\t \"text-class\" =>\"text-center\",\n";
$code .= "\t\t \"text\"=>sprintf(lang(\"{$ucf_component}.delete-message\"),\$name),\n";
$code .= "\t\t \"content\" =>\$f,\n";
$code .= "));\n";
$code .= "echo(\$card);\n";
$code .= "?>\n";
echo($code);
?>