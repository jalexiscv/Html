<?php
/** @var  $bootstrap */
/** @var  $model */
/** @var  $oid */

$bootstrap = service("bootstrap");
$numbers = service("numbers");
$dates = service("dates");
//[models]--------------------------------------------------------------------------------------------------------------
$mdimensions = model('App\Modules\Mipg\Models\Mipg_Dimensions');
$mpolitics = model('App\Modules\Mipg\Models\Mipg_Politics');
$mdiagnostics = model('App\Modules\Mipg\Models\Mipg_Diagnostics');
$mcomponents = model('App\Modules\Mipg\Models\Mipg_Components');
$mcategories = model('App\Modules\Mipg\Models\Mipg_Categories');
$mactivities = model('App\Modules\Mipg\Models\Mipg_Activities');
$mplans = model('App\Modules\Mipg\Models\Mipg_Plans');
$mactions = model('App\Modules\Mipg\Models\Mipg_Actions');
$mattachments = model('App\Modules\Mipg\Models\Mipg_Attachments');
//$oid Recibe  "Plan"
$plan = $mplans->getPlan($oid);
$activity = $mactivities->get_Activity($plan['activity']);
$category = $mcategories->get_Category($activity['category']);
$component = $mcomponents->get_Component($category['component']);
$diagnostic = $mdiagnostics->get_Diagnostic($component['diagnostic']);
$politic = $mpolitics->get_Politic($diagnostic['politic']);
$dimension = $mdimensions->get_Dimension($politic['dimension']);
//[vars]----------------------------------------------------------------------------------------------------------------
$plan = $model->getPlan($oid);
$actions = $mactions->get_ListByPlan(1000, 0, $oid);
$actions_count = count($actions);

$completeds = 0;
foreach ($actions as $action) {
    $files = $mattachments->get_FileListForObject($action['action']);
    if (count($files) > 0) {
        $completeds++;
    }
}

$percentage = 0;
if ($actions_count > 0) {
    $percentage = (($completeds * 100) / $actions_count);
}

$remaining = $dates->get_leftTime($plan['end'], "days");

$back = "/mipg/plans/view/{$oid}";

$code = "";
$code .= "\t<style>\n";
$code .= "\t\t.label {\n";
$code .= "\t\t\tfont-size: 1rem;\n";
$code .= "\t\t\tline-height: 0.75rem;\n";
$code .= "\t\t\tcolor: #000;\n";
$code .= "\t\t\twidth: 100%;\n";
$code .= "\t\t\tbackground-color: #f8f8f8;\n";
$code .= "\t\t\tpadding: 5px;\n";
$code .= "\t\t\tborder-top: none;\n";
$code .= "\t\t\tborder-bottom: 1px solid #dfdfdf;\n";
$code .= "\t\t\tfont-weight: normal;\n";
$code .= "\t\t}\n";
$code .= "\n";
$code .= "\t\t.value {\n";
$code .= "\t\t\tfont-size: 14px;\n";
$code .= "\t\t\tline-height: 14px;\n";
$code .= "\t\t\tcolor: #000000;\n";
$code .= "\t\t\twidth: 100%;\n";
$code .= "\t\t\tpadding: 5px;\n";
$code .= "\t\t}\n";
$code .= "\n";
$code .= "\t\t.field {\n";
$code .= "\t\t\tfont-size: 1rem;\n";
$code .= "\t\t\tpadding: 0;\n";
$code .= "\t\t\tcolor: #000000;\n";
$code .= "\t\t\tline-height: 1rem;\n";
$code .= "\t\t\tmargin-bottom: 5px;\n";
$code .= "\t\t\tborder: 1px solid #dfdfdf;\n";
$code .= "\t\t\tbackground-color: #ffffff;\n";
$code .= "\t\t}\n";
$code .= "\t</style>\n";
$code .= "\t<div class=\"row\">\n";
$code .= "\t\t<div class=\"col-12\">\n";
$code .= "\t\t\t<div class=\"row pr-3 pl-3\">\n";
$code .= "\t\t\t\t<div class=\"col-3 field\">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow\">Dimensión</div>\n";
$code .= "\t\t\t\t\t<div class=\"value text-center\">{$dimension['name']}</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-3 field\">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow\">Política</div>\n";
$code .= "\t\t\t\t\t<div class=\"value text-center\">{$politic['name']}</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-3 field text-center\">\n";
$code .= "\t\t\t\t\t<div class=\"label bg-yellow\">Componente</div>\n";
$code .= "\t\t\t\t\t<div class=\"value text-center\">{$component['name']}</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-3 field\">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow\">Categoría</div>\n";
$code .= "\t\t\t\t\t<div class=\"value text-center\">{$category['name']}</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t</div>\n";
$code .= "\t\t\t<div class=\"row pr-3 pl-3 \">\n";
$code .= "\t\t\t\t<div class=\"col-12 field\">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow p-1\"><b>Actividad</b></div>\n";
$code .= "\t\t\t\t\t<div class=\"value\">{$activity['description']}</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t</div>\n";
$code .= "\t\t\t<div class=\"row pr-3 pl-3 e\">\n";
$code .= "\t\t\t\t<div class=\"col-12 field \">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow p-1\"><b>Descripción del plan</b></div>\n";
$code .= "\t\t\t\t\t<div class=\"value\">{$plan['description']}</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t</div>\n";
$code .= "\t\t\t<div class=\"row pr-3 pl-3\">\n";
$code .= "\t\t\t\t<div class=\"col-4 field\">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow\">Acciones Propuestas</div>\n";
$code .= "\t\t\t\t\t<div class=\"value text-center\">{$actions_count}</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-4 field\">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow\">Acciones Cumplidas</div>\n";
$code .= "\t\t\t\t\t<div class=\"value text-center\">{$completeds}</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-4 field\">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow\">Porcentaje de avance</div>\n";
$code .= "\t\t\t\t\t<div class=\"value text-center\">{$percentage}%</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t</div>\n";
$code .= "\t\t\t<div class=\"row pr-3 pl-3\">\n";
$code .= "\t\t\t\t<div class=\"col-4 field\">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow\">Fecha de Inicio</div>\n";
$code .= "\t\t\t\t\t<div class=\"value text-center\">{$plan['start']}</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-4 field\">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow\">Fecha Finalización</div>\n";
$code .= "\t\t\t\t\t<div class=\"value text-center\">{$plan['end']}</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-4 field\">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow\">Dias Restantes</div>\n";

if ($plan['status'] == "COMPLETED") {
    $code .= "\t\t\t\t\t<div class=\"value text-center\">0 Dias</div>\n";
} else {
    if ($remaining > 0) {
        $code .= "\t\t\t\t\t<div class=\"value text-center color-green\">{$remaining} Dias</div>\n";
    } else {
        $code .= "\t\t\t\t\t<div class=\"value text-center color-red\"><b>{$remaining} Dias</b></div>\n";
    }

}

$mfields = model('App\Modules\Mipg\Models\Mipg_Users_Fields');
$mprocesses = model('App\Modules\Mipg\Models\Mipg_Processes');
$process = $mprocesses->get_Process($plan['manager']);
$profile = $mfields->get_Profile($process['responsible']);

$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t</div>\n";
$code .= "\t\t\t<div class=\"row pr-3 pl-3\">\n";
$code .= "\t\t\t\t<div class=\"col-12 field text-center bg-orange p-1\"><b> Responsable del Plan de Acción </b></div>\n";
$code .= "\t\t\t</div>\n";
$code .= "\t\t\t<div class=\"row pr-3 pl-3\">\n";
$code .= "\t\t\t\t<div class=\"col-6 field\">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow\">Proceso</div>\n";
$code .= "\t\t\t\t\t<div class=\"value text-center\">{$process['name']}</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t\t<div class=\"col-6 field\">\n";
$code .= "\t\t\t\t\t<div class=\"label text-center bg-yellow\">Responsable</div>\n";
$code .= "\t\t\t\t\t<div class=\"value text-center\">{$profile['name'] }</div>\n";
$code .= "\t\t\t\t</div>\n";
$code .= "\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "\t</div>\n";


//print_r($plan);


$card = $bootstrap->get_Card("card-view-service", array(
    "title" => sprintf("Detalles del Plan de acción %s", $numbers->pad_LeftWithZeros($plan['order'], 4)),
    "header-back" => $back,
    "content" => $code,
    "content-class" => "p-2",
));
echo($card);
?>