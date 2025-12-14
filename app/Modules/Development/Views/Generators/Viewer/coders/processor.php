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
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\{$ucf_options}\\Editor\\processor.php";
    $plural = "{$slc_module}-{$slc_component}-{$slc_options}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/{$ucf_options}/View";
    $ajax = "/{$slc_module}/{$slc_component}/{$slc_options}/ajax/list?time=\".time()";
} else {
    $model = "App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}";
    $path = '/' . $slc_module . '/' . $slc_component;
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\Editor\\processor.php";
    $plural = "{$slc_module}-{$slc_component}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/_List";
    $ajax = "/{$slc_module}/{$slc_component}/ajax/list/";
}

$db = Database::connect("default");
$fields = $db->getFieldNames($id);

$code = "<?php\n";
$code .= get_development_code_copyright(array("path" => $namespaced));
$code .= COMMENT_HR_SERVICES;
$code .= "\$request = service('Request');\n";
$code .= "\$bootstrap = service('Bootstrap');\n";
$code .= "\$dates = service('Dates');\n";
$code .= "\$strings = service('strings');\n";
$code .= "\$authentication =service('authentication');\n";
$code .= COMMENT_HR_VARS;
$code .= COMMENT_MODULECONTROLER_VARS;
$code .= "\$f = service(\"forms\",array(\"lang\" => \"{$ucf_module}_{$ucf_component}.\"));\n";
$code .= "\$model = model(\"App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}\");\n";
$code .= "\$d = array(\n";
foreach ($fields as $field) {
    if ($field != "created_at" && $field != "updated_at" && $field != "deleted_at") {
        if ($field == "author") {
            $code .= "    \"{$field}\" => safe_get_user(),\n";
        } else {
            $code .= "    \"{$field}\" => \$f->get_Value(\"{$field}\"),\n";
        }
    }
}
$code .= ");\n";
$code .= COMMENT_HR_BUILD;
$code .= "\$row = \$model->find(\$d[\"{$fields[0]}\"]);\n";
$code .= "if (isset(\$row[\"{$fields[0]}\"])) {\n";
$code .= "//\$edit = \$model->update(\$d);\n";
$code .= "\$c = \$bootstrap->get_Card('warning', array(\n";
$code .= "\t\t\t\t'class' => 'card-warning',\n";
$code .= "\t\t\t\t'icon' => 'fa-duotone fa-triangle-exclamation',\n";
$code .= "\t\t\t\t'text-class' => 'text-center',\n";
$code .= "\t\t\t\t'title' => lang(\"{$ucf_module}_{$ucf_component}.view-success-title\"),\n";
$code .= "\t\t\t\t'text' => lang(\"{$ucf_module}_{$ucf_component}.view-success-message\"),\n";
$code .= "\t\t\t\t'footer-class' => 'text-center',\n";
$code .= "\t\t\t\t'footer-continue' => base_url(\"/{$slc_module}/{$slc_component}/view/{\$d[\"{$fields[0]}\"]}/\".lpk()),\n";
$code .= "\t\t\t\t'voice' => \"{$slc_module}/{$slc_component}-view-success-message.mp3\",\n";
$code .= "\t\t));\n";
$code .= "}else {\n";
$code .= "\$c = \$bootstrap->get_Card('success', array(\n";
$code .= "\t\t\t\t'class' => 'card-success',\n";
$code .= "\t\t\t\t'icon' => 'fa-duotone fa-triangle-exclamation',\n";
$code .= "\t\t\t\t'text-class' => 'text-center',\n";
$code .= "\t\t\t\t'title' => lang(\"{$ucf_module}_{$ucf_component}.view-noexist-title\"),\n";
$code .= "\t\t\t\t'text' => lang(\"{$ucf_module}_{$ucf_component}.view-noexist-message\"),\n";
$code .= "\t\t\t\t'footer-class' => 'text-center',\n";
$code .= "\t\t\t\t'footer-continue' => base_url(\"/{$slc_module}/{$slc_component}\"),\n";
$code .= "\t\t\t\t'voice' => \"{$slc_module}/{$slc_component}-view-noexist-message.mp3\",\n";
$code .= "\t\t));\n";
$code .= "}\n";
$code .= "echo(\$c);\n";
$code .= "?>\n";
echo($code);
?>