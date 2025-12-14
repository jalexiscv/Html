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
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\{$ucf_options}\\Creator\\form.php";
    $plural = "{$slc_module}-{$slc_component}-{$slc_options}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/{$ucf_options}/_Creator";
    $ajax = "/{$slc_module}/{$slc_component}/{$slc_options}/ajax/list?time=\".time()";
} else {
    $model = "App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}";
    $path = '/' . $slc_module . '/' . $slc_component;
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\Creator\\form.php";
    $plural = "{$slc_module}-{$slc_component}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/_List";
    $ajax = "/{$slc_module}/{$slc_component}/ajax/list/";
}

$db = Database::connect("default");
$fields = $db->getFieldNames($id);

$code = "<?php\n";
$code .= get_nexus_code_copyright(array("path" => $namespaced));

$code .= COMMENT_HR_SERVICES;
$code .= "\$b = service(\"bootstrap\");\n";
$code .= "\$f = service(\"forms\",array(\"lang\" => \"{$ucf_module}.{$slc_component}-\"));\n";

$code .= COMMENT_HR_MODELS;
$code .= "//\$model = model(\"App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}\");\n";

$code .= COMMENT_HR_VARS;
foreach ($fields as $field) {
    if ($field == "author") {
        $code .= "\$r[\"{$field}\"] = \$f->get_Value(\"{$field}\",safe_get_user());\n";
    } else if ($field == "date") {
        $code .= "\$r[\"{$field}\"] = \$f->get_Value(\"{$field}\",service(\"dates\")::get_Date());\n";
    } else if ($field == "time") {
        $code .= "\$r[\"{$field}\"] = \$f->get_Value(\"{$field}\",service(\"dates\")::get_Time());\n";
    } else {
        $code .= "\$r[\"{$field}\"] = \$f->get_Value(\"{$field}\");\n";
    }
}
$code .= "\$back= \"/{$slc_module}/{$slc_component}/list/\".lpk();\n";

$code .= COMMENT_HR_FIELDS;
foreach ($fields as $field) {
    if ($field == "author") {
        $code .= "\$f->add_HiddenField(\"author\",\$r[\"author\"]);\n";
    } else {
        $code .= "\$f->fields[\"{$field}\"] = \$f->get_FieldText(\"{$field}\", array(\"value\" => \$r[\"{$field}\"],\"proportion\"=>\"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12\"));\n";
    }
}
$code .= "\$f->fields[\"cancel\"]=\$f->get_Cancel(\"cancel\", array(\"href\" =>\$back,\"text\" =>lang(\"App.Cancel\"),\"type\"=>\"secondary\",\"proportion\" =>\"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right\"));\n";
$code .= "\$f->fields[\"submit\"] =\$f->get_Submit(\"submit\", array(\"value\" =>lang(\"App.Create\"),\"proportion\" =>\"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left\"));\n";


$code .= COMMENT_HR_GROUPS;
$grupo = 0;
$conteo = 0;
for ($i = 0; $i < count($fields); $i++) {

    $fcode = "";
    $field = $fields[$i];
    if ($conteo == 0) {
        $grupo++;
        $fcode .= "\$f->groups[\"g{$grupo}\"]=\$f->get_Group(array(\"legend\"=>\"\",\"fields\"=>(";
    }

    if ($field != "author" && $field != "created_at" && $field != "updated_at" && $field != "deleted_at") {
        $fcode .= "\$f->fields[\"{$field}\"]";
    }

    $conteo++;
    if ($conteo == 3) {
        $fcode .= ")));\n";
        $conteo = 0;
    } else {
        if (!isset($fields[$i + 1])) {
            $fcode .= ")));\n";
        } else {
            if ($field != "author" && $field != "created_at" && $field != "updated_at" && $field != "deleted_at") {
                $fcode .= ".";
            }
        }
    }

    if (strpos($fcode, '()));') !== false) {
        $code .= "";
    } else {
        $code .= $fcode;
    }


}


$code .= COMMENT_HR_BUTTONS;
$code .= "\$f->groups[\"gy\"] =\$f->get_GroupSeparator();\n";
$code .= "\$f->groups[\"gz\"] = \$f->get_Buttons(array(\"fields\"=>\$f->fields[\"submit\"].\$f->fields[\"cancel\"]));\n";

$code .= COMMENT_HR_BUILD;
$code .= "\$card = \$b->get_Card(\"create\", array(\n";
$code .= "\t\t \"title\" => lang(\"{$ucf_module}.{$slc_component}-create-title\"),\n";
$code .= "\t\t \"content\" =>\$f,\n";
$code .= "));\n";
$code .= "echo(\$card);\n";
$code .= "?>\n";

echo($code);
?>