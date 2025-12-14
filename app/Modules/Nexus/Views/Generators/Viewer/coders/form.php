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
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\{$ucf_options}\\Editor\\form.php";
    $plural = "{$slc_module}-{$slc_component}-{$slc_options}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/{$ucf_options}/View";
    $ajax = "/{$slc_module}/{$slc_component}/{$slc_options}/ajax/list?time=\".time()";
} else {
    $model = "App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}";
    $path = '/' . $slc_module . '/' . $slc_component;
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\Editor\\form.php";
    $plural = "{$slc_module}-{$slc_component}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/_List";
    $ajax = "/{$slc_module}/{$slc_component}/ajax/list/";
}

$db = Database::connect("default");
$fields = $db->getFieldNames($id);

$code = "<?php\n";
$code .= get_nexus_code_copyright(array("path" => $namespaced));

$code .= "//[Services]-----------------------------------------------------------------------------\n";
$code .= "\$request = service('Request');\n";
$code .= "\$bootstrap = service('Bootstrap');\n";
$code .= "\$dates = service('Dates');\n";
$code .= "\$strings = service('strings');\n";
$code .= "\$authentication =service('authentication');\n";

$code .= "\$f = service(\"forms\",array(\"lang\" => \"{$ucf_module}.{$slc_component}-\"));\n";
$code .= "//[Request]-----------------------------------------------------------------------------\n";
//$code .= "\$model = model(\"App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}\");\n";
$code .= "\$row=\$model->find(\$oid);\n";
foreach ($fields as $field) {
    $code .= "\$r[\"{$field}\"] =\$row[\"$field\"];\n";
}
$code .= "\$back= \"/{$slc_module}/{$slc_component}/list/\".lpk();\n";
$code .= "//[Fields]-----------------------------------------------------------------------------\n";
foreach ($fields as $field) {
    if ($field == "author") {
        $code .= "\$f->add_HiddenField(\"author\",\$r[\"author\"]);\n";
    } else {
        $code .= "\$f->fields[\"{$field}\"] = \$f->get_FieldView(\"{$field}\", array(\"value\" => \$r[\"{$field}\"],\"proportion\"=>\"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12\"));\n";
    }
}
$code .= "\$f->fields[\"cancel\"]=\$f->get_Cancel(\"cancel\", array(\"href\" =>\$back,\"text\" =>lang(\"App.Cancel\"),\"type\"=>\"secondary\",\"proportion\" =>\"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right\"));\n";
$code .= "\$f->fields[\"edit\"] =\$f->get_Button(\"edit\", array(\"href\" =>\"/{$slc_module}/{$slc_component}/edit/\".\$oid,\"text\" =>lang(\"App.Edit\"),\"class\"=>\"btn btn-secondary\",\"proportion\" =>\"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right\"));\n";
$code .= "//[Groups]-----------------------------------------------------------------------------\n";
$grupo = 0;
$conteo = 0;
for ($i = 0; $i < count($fields); $i++) {
    $field = $fields[$i];
    if ($conteo == 0) {
        $grupo++;
        $code .= "\$f->groups[\"g{$grupo}\"]=\$f->get_Group(array(\"legend\"=>\"\",\"fields\"=>(";
    }
    $code .= "\$f->fields[\"{$field}\"]";
    $conteo++;
    if ($conteo == 3) {
        $code .= ")));\n";
        $conteo = 0;
    } else {
        if (!isset($fields[$i + 1])) {
            $code .= ")));\n";
        } else {
            $code .= ".";
        }
    }
}
$code .= "//[Buttons]-----------------------------------------------------------------------------\n";
$code .= "\$f->groups[\"gy\"] =\$f->get_GroupSeparator();\n";
$code .= "\$f->groups[\"gz\"] = \$f->get_Buttons(array(\"fields\"=>\$f->fields[\"edit\"].\$f->fields[\"cancel\"]));\n";


$code .= "//[Build]-----------------------------------------------------------------------------\n";
$code .= "\$smarty = service(\"smarty\");\n";
$code .= "\$smarty->set_Mode(\"bs5x\");\n";
$code .= "\$smarty->assign(\"type\", \"normal\");\n";
$code .= "\$smarty->assign(\"header\", lang(\"{$ucf_module}.{$slc_component}-view-title\"));\n";
$code .= "\$smarty->assign(\"header_back\", \$back);\n";
$code .= "\$smarty->assign(\"body\", \$f);\n";
$code .= "\$smarty->assign(\"footer\", null);\n";
$code .= "\$smarty->assign(\"file\", __FILE__);\n";
$code .= "echo(\$smarty->view('components/cards/index.tpl'));\n";
$code .= "?>\n";

echo($code);
?>