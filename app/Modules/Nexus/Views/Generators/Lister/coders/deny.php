<?php

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
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\{$ucf_options}\\List\\deny.php";
    $plural = "{$slc_module}-{$slc_component}-{$slc_options}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/{$ucf_options}/_List";
    $ajax = "/{$slc_module}/{$slc_component}/{$slc_options}/ajax/list?time=\".time()";
} else {
    $model = "App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}";
    $path = '/' . $slc_module . '/' . $slc_component;
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\List\\deny.php";
    $plural = "{$slc_module}-{$slc_component}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/_List";
    $ajax = "/{$slc_module}/{$slc_component}/ajax/list/";
}

$code = "<?php\n";
$code .= get_nexus_code_copyright(array("path" => $namespaced));
$code .= "\$bootstrap = service(\"bootstrap\");\n";
$code .= "\$continue=\"/{$slc_module}/{$slc_component}\";\n";
$code .= "if (\$authentication->get_LoggedIn()) {\n";
$code .= "    \$card = \$bootstrap->get_Card(\"access-denied\", array(\n";
$code .= "        \"class\" => \"card-danger\",\n";
$code .= "        \"title\" => lang(\"App.Access-denied-title\"),\n";
$code .= "        \"icon\" => \"fa-duotone fa-triangle-exclamation\",";
$code .= "        \"text-class\" => \"text-center\",";
$code .= "        \"text\" => lang(\"App.Access-denied-message\"),\n";
$code .= "        \"permissions\" => \$permissions,\n";
$code .= "        \"footer-class\" => \"text-center\",\n";
$code .= "        \"footer-login\" => true,\n";
$code .= "        \"footer-continue\" => \$continue,\n";
$code .= "        \"voice\" => \"{$slc_module}/{$slc_component}-create-denied-message.mp3\"\n";
$code .= "    ));\n";
$code .= "} else {\n";
$code .= "    \$card = \$bootstrap->get_Card(\"access-denied\", array(\n";
$code .= "        \"class\" => \"card-danger\",\n";
$code .= "        \"title\" => lang(\"App.login-required-title\"),\n";
$code .= "        \"icon\" => \"fa-duotone fa-triangle-exclamation\",\n";
$code .= "        \"text-class\" => \"text-center\",\n";
$code .= "        \"text\" => lang(\"App.login-required-message\"),\n";
$code .= "        \"permissions\" => \$permissions,\n";
$code .= "        \"footer-class\" => \"text-center\",\n";
$code .= "        \"footer-login\" => true,\n";
$code .= "        \"footer-continue\" => \$continue,\n";
$code .= "        \"voice\" => \"{$slc_module}/{$slc_component}-create-denied-message.mp3\"\n";
$code .= "    ));\n";
$code .= "}\n";
$code .= "echo(\$card);\n";
$code .= "?>";
echo($code);
?>