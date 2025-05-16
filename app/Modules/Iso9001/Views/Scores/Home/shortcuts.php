<?php

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$strings = service("strings");
$mdiagnostics = model('App\Modules\Iso9001\Models\Iso9001_Diagnostics');
$diagnostics = $mdiagnostics->where("requirement", $oid)->findAll();
//[vars]----------------------------------------------------------------------------------------------------------------
//Recibe el activity $activity
$mdiagnostics = model('App\Modules\R\Models\Iso9001_Diagnostics');
$mcomponents = model('App\Modules\Iso9001\Models\Iso9001_Components');
$mcategories = model('App\Modules\Iso9001\Models\Iso9001_Categories');
$mactivities = model('App\Modules\Iso9001\Models\Iso9001_Activities');
$mscores = model('App\Modules\Iso9001\Models\Iso9001_Scores');


$activity = $mactivities->getActivity($oid);
$scores = $mscores->where("activity", $oid)->orderBy("created_at", "DESC")->findAll();
$back = "/iso9001/activities/home/{$activity["category"]}";

$code = "<div class=\"row\">\n";

$code .= "\t<div class=\"col\">\n";
$code .= "\t\t <table class=\"table table-bordered table-hover w-100 m-0 \">\n";
$code .= "\t\t\t <thead class=\"\">\n";
$code .= "\t\t\t\t <tr>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">#</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Detalles</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Puntaje</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Fecha</th>\n";
//$code .= "\t\t\t\t\t <th class=\"th text-center\">Opciones</th>\n";
$code .= "\t\t\t\t </tr>\n";
$code .= "\t\t\t </thead>\n";
$code .= "\t\t\t <tbody>\n";

$count = count($scores);
foreach ($scores as $score) {
    $plan = "00";
    $status = "Estado";
    $description = $strings->get_Striptags($score["details"]);
    $content = "{$description}</br>";
    $value = $score["value"];
    $options = "<i class=\"fa-light fa-table-list\"></i>";
    $code .= "\t\t\t\t <tr>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">$count</td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-start align-middle\">$content</td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">";
    $code .= "\t\t\t\t\t\t {$value}";
    $code .= "\t\t\t\t\t </td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">{$score['created_at']}</td>\n";
    //$code .= "\t\t\t\t\t <td class=\"text-center align-middle\">$options</td>\n";
    $code .= "\t\t\t\t </tr>\n";
    $count--;
}
$code .= "\t\t\t</tbody>\n";
$code .= "\t\t</table>\n";
$code .= "\t</div>\n";
$code .= "</div>\n";

$title = lang('App.Activity');
$message = $strings->get_Clear($activity["description"]);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => sprintf(lang('Iso9001_Scores.home-title'), ""),
    "header-back" => $back,
    //"header-list" => '/iso9001/activities/list/' . $oid,
    "header-add" => "/iso9001/scores/create/{$oid}",
    "alert" => array(
        'type' => 'info',
        'title' => $title,
        'message' => $message
    ),
    "content" => $code,
));
echo($card);
//[files]----------------------------------------------------------------------------------------------------------------
$files = $bootstrap->get_Card2("create", array(
    "header-title" => "Evidencias de la Actividad",
    "content" => view('App\Modules\Iso9001\Views\Scores\Home\files', array("oid" => $oid)),
    //"header-back" =>$back
));
echo($files);
//[info]---------------------------------------------------------------------------------------------------------------
$info = $bootstrap->get_Card2("card-view-service", array(
    "alert" => array(
        'type' => 'secondary',
        'title' => lang("Iso9001_Iso9001.califications-info-title"),
        'message' => lang("Iso9001_Iso9001.califications-info-message"),
        'class' => 'mb-0'
    ),
));
//echo($info);
?>