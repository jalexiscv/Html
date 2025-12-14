<?php

use Config\Database;

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-05 03:52:50
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Organization\Views\Plans\Editor\form.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * * █ @var object $authentication Trasferido desde el controlador
 * * █ @var object $request Trasferido desde el controlador
 * * █ @var object $dates Trasferido desde el controlador
 * * █ @var string $component Trasferido desde el controlador
 * * █ @var string $view Trasferido desde el controlador
 * * █ @var string $oid Trasferido desde el controlador
 * * █ @var string $views Trasferido desde el controlador
 * * █ @var string $prefix Trasferido desde el controlador
 * * █ @var array $data Trasferido desde el controlador
 * * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
$strings = service("strings");

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
$sucf_component = $strings->removePluralEnding($ucf_component);

if (count($eid) == 3) {
    $model = "App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}_{$ucf_options}";
    $path = '/' . $slc_module . '/' . $slc_component . '/' . $slc_options;
    $namespaced = "App\\Modules\\{$ucf_module}\\Views\\{$ucf_component}\\{$ucf_options}\\Editor\\form.php";
    $plural = "{$slc_module}-{$slc_component}-{$slc_options}-view-all";
    $pathfiles = APPPATH . "Modules/{$ucf_module}/Views/{$ucf_component}/{$ucf_options}/_Editor";
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
$code .= get_development_code_copyright(array("path" => $namespaced));

$code .= COMMENT_HR_SERVICES;
$code .= "\$request = service('request');\n";
$code .= "\$bootstrap = service('bootstrap');\n";
$code .= "\$dates = service('dates');\n";
$code .= "\$strings = service('strings');\n";
$code .= "\$authentication =service('authentication');\n";
$code .= "\$server = service(\"server\");\n";
$code .= "\$f = service(\"forms\",array(\"lang\" => \"{$ucf_module}_{$ucf_component}.\"));\n";

$code .= COMMENT_HR_MODELS;
$code .= "//\$model = model(\"App\\Modules\\{$ucf_module}\\Models\\{$ucf_module}_{$ucf_component}\");\n";

$code .= COMMENT_HR_VARS;

$code .= COMMENT_MODULECONTROLER_VARS;
$code .= "\$row= \$model->get{$sucf_component}(\$oid);\n";
foreach ($fields as $field) {
    if ($field == "author") {
        $code .= "\$r[\"{$field}\"] = \$f->get_Value(\"{$field}\",safe_get_user());\n";
    } else if ($field == "date") {
        $code .= "\$r[\"{$field}\"] = \$f->get_Value(\"{$field}\",service(\"dates\")::get_Date());\n";
    } else if ($field == "time") {
        $code .= "\$r[\"{$field}\"] = \$f->get_Value(\"{$field}\",service(\"dates\")::get_Time());\n";
    } else {
        $code .= "\$r[\"{$field}\"] = \$f->get_Value(\"{$field}\",\$row[\"$field\"]);\n";
    }
}
$code .= "\$back=\$f->get_Value(\"back\",\$server->get_Referer());\n";

$code .= COMMENT_HR_FIELDS;
$code .= "\$f->add_HiddenField(\"back\",\$back);\n";
foreach ($fields as $field) {
    if ($field == "author") {
        $code .= "\$f->add_HiddenField(\"author\",\$r[\"author\"]);\n";
    } else {
        $code .= "\$f->fields[\"{$field}\"] = \$f->get_FieldText(\"{$field}\", array(\"value\" => \$r[\"{$field}\"],\"proportion\"=>\"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12\"));\n";
    }
}
$code .= "\$f->fields[\"cancel\"]=\$f->get_Cancel(\"cancel\", array(\"href\" =>\$back,\"text\" =>lang(\"App.Cancel\"),\"type\"=>\"secondary\",\"proportion\" =>\"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right\"));\n";
$code .= "\$f->fields[\"submit\"] =\$f->get_Submit(\"submit\", array(\"value\" =>lang(\"App.Edit\"),\"proportion\" =>\"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left\"));\n";

$code .= COMMENT_HR_GROUPS;
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

$code .= COMMENT_HR_BUTTONS;
$code .= "\$f->groups[\"gy\"] =\$f->get_GroupSeparator();\n";
$code .= "\$f->groups[\"gz\"] = \$f->get_Buttons(array(\"fields\"=>\$f->fields[\"submit\"].\$f->fields[\"cancel\"]));\n";

$code .= COMMENT_HR_BUILD;
$code .= "\$card = \$bootstrap->get_Card(\"create\", array(\n";
$code .= "\t\t \"title\" => lang(\"{$ucf_module}_{$ucf_component}.edit-title\"),\n";
$code .= "\t\t \"content\" =>\$f,\n";
$code .= "\t\t \"header-back\" =>\$back\n";
$code .= "));\n";
$code .= "echo(\$card);\n";
$code .= "?>\n";

echo($code);
?>