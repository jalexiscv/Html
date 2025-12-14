<?php

/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$strings = service("strings");
$mdiagnostics = model('App\Modules\Mipg\Models\Mipg_Diagnostics');
$diagnostics = $mdiagnostics->where("politic", $oid)->findAll();
//[vars]----------------------------------------------------------------------------------------------------------------
//Recibe el activity $activity
$mdiagnostics = model('App\Modules\Mipg\Models\Mipg_Diagnostics');
$mcomponents = model('App\Modules\Mipg\Models\Mipg_Components');
$mcategories = model('App\Modules\Mipg\Models\Mipg_Categories');
$mactivities = model('App\Modules\Mipg\Models\Mipg_Activities');
$mscores = model('App\Modules\Mipg\Models\Mipg_Scores');


$activity = $mactivities->get_Activity($oid);
$scores = $mscores->where("activity", $oid)->orderBy("created_at", "DESC")->findAll();
$back = "/mipg/activities/home/{$activity["category"]}";

$code = "<div class=\"row\">\n";

$code .= "\t<div class=\"col\">\n";
$code .= "\t\t <table class=\"table table-bordered table-hover w-100 m-0 \">\n";
$code .= "\t\t\t <thead class=\"\">\n";
$code .= "\t\t\t\t <tr>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">#</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Detalles</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Puntaje</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Fecha</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Opciones</th>\n";
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
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">$options</td>\n";
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
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => sprintf(lang('Mipg_Scores.home-title'), ""),
    "header-back" => $back,
    //"header-list" => '/mipg/activities/list/' . $oid,
    "header-add" => "/mipg/scores/create/{$oid}",
    "alert" => array(
        'type' => 'info',
        'title' => $title,
        'message' => $message
    ),
    "content" => $code,
));
echo($card);
//[files]----------------------------------------------------------------------------------------------------------------
$files= $bootstrap->get_Card2("create", array(
    "header-title" => "Evidencias de la Actividad",
    "content" =>view('App\Modules\Mipg\Views\Scores\Home\files',array("oid"=>$oid)),
    //"header-back" =>$back
));
echo($files);
//[info]---------------------------------------------------------------------------------------------------------------
$info = $bootstrap->get_Card("card-view-service", array(
    "alert" => array(
        'type' => 'secondary',
        'title' => lang("Mipg_Mipg.califications-info-title"),
        'message' => lang("Mipg_Mipg.califications-info-message"),
        'class' => 'mb-0'
    ),
));
//echo($info);
?>