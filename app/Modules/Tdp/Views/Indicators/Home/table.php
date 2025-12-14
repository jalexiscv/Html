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
//[models]--------------------------------------------------------------------------------------------------------------
$mdimensions = model('App\Modules\Tdp\Models\Tdp_Dimensions');
$mlines = model('App\Modules\Tdp\Models\Tdp_Lines');
$mdiagnostics = model('App\Modules\Tdp\Models\Tdp_Diagnostics');
$msectors = model('App\Modules\Tdp\Models\Tdp_Sectors');
$mprograms = model('App\Modules\Tdp\Models\Tdp_Programs');
$mproducts = model('App\Modules\Tdp\Models\Tdp_Products');
$mindicators = model('App\Modules\Tdp\Models\Tdp_Indicators');
//[vars]----------------------------------------------------------------------------------------------------------------
//[request]-------------------------------------------------------------------------------------------------------------
$product = $mproducts->get_Product($oid);
$program = $mprograms->get_Program($product['program']);
$sector = $msectors->get_Sector($program['sector']);
$diagnostic = $mdiagnostics->get_Diagnostic($sector['diagnostic']);
$line = $mlines->get_Line($diagnostic['line']);
$dimension = $mdimensions->get_Dimension($line['dimension']);

$indicators = $mindicators->get_List(1000, 0, "", $oid);
$back = "/tdp/products/home/{$program["program"]}";

$code = "<div class=\"row\">\n";
$count = 0;
$code .= "\t<div class=\"col\">\n";
$code .= "\t\t <table class=\"table table-bordered table-hover w-100 m-0 \">\n";
$code .= "\t\t\t <thead class=\"\">\n";
$code .= "\t\t\t\t <tr>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">#</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Indicador</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Riesgo</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Planes</th>\n";
$code .= "\t\t\t\t\t <th class=\"th text-center\">Puntaje</th>\n";
$code .= "\t\t\t\t </tr>\n";
$code .= "\t\t\t </thead>\n";
$code .= "\t\t\t <tbody>\n";
foreach ($indicators as $indicator) {
    $count++;
    $plan = "00";
    $status = "Estado";
    $period = $indicator["period"];
    $description = $strings->get_Striptags($indicator["description"]);
    $content = "{$description}</br>";
    $content .= "<b>Periodo</b>:{$period}</br>";
    $content .= "<b>Plan actual</b>:{$plan} | <b>Estado</b>:{$status}";
    $score = $mindicators->get_Score($indicator["indicator"]);

    $options = "<i class=\"fa-light fa-table-list\"></i>";
    $code .= "\t\t\t\t <tr>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">$count</td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-start align-middle\">$content</td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">";
    $code .= "\t\t\t\t\t\t <a href=\"#\"></a>";
    $code .= "\t\t\t\t\t </td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">";
    $code .= "\t\t\t\t\t\t <a href=\"/#\">P</a>";
    $code .= "\t\t\t\t\t </td>\n";
    $code .= "\t\t\t\t\t <td class=\"text-center align-middle\">";
    $code .= "\t\t\t\t\t\t <a href=\"/tdp/scores/home/{$indicator['indicator']}\">$score</a>";
    $code .= "\t\t\t\t\t </td>\n";
    $code .= "\t\t\t\t </tr>\n";
}
$code .= "\t\t\t</tbody>\n";
$code .= "\t\t</table>\n";
$code .= "\t</div>\n";
$code .= "</div>\n";

$title = $strings->get_Clear($product["name"]);
$message = $strings->get_Clear($product["description"]);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => sprintf(lang('Indicators.tdp-list-title'), ""),
    "header-back" => $back,
    "header-list" => '/tdp/indicators/list/' . $oid,
    "alert" => array(
        'type' => 'info',
        'title' => $title,
        'message' => $message
    ),
    "content" => $code,
));
echo($card);
//[info]----------------------------------------------------------------------------------------------------------------
$info = $bootstrap->get_Card("card-view-service", array(
    "alert" => array('type' => 'secondary', 'title' => lang("Activities.definition-info-title"), 'message' => lang("Activities.definition-info-message"), 'class' => 'mb-0'),
));
echo($info);
?>