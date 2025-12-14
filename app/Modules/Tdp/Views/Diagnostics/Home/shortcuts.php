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
$mdiagnostics = model('App\Modules\Tdp\Models\Tdp_Diagnostics');
$mlines = model('App\Modules\Tdp\Models\Tdp_Lines');
//[data]---------------------------------------------------------------------------------------------------------------
$diagnostics = $mdiagnostics->where("line", $oid)->orderBy("order", "DESC")->findAll();
$line = $mlines->get_Line($oid);
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/tdp/lines/home/{$line['dimension']}";

$code = "<div class=\"row\trow-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1\ttext-center shortcuts\">\n";
$count = 0;
foreach ($diagnostics as $diagnostic) {
    $count++;
    $score = $mdiagnostics->get_Score($diagnostic['diagnostic']);
    $percentage = $score;
    $title = $diagnostic['name'];
    $subtitle = "$percentage%";
    $code .= "\t\t<div class=\"col mb-1\">\n";
    $code .= "<div class=\"card mb-1\">\n";
    $code .= "\t<div class=\"card-body d-flex align-items-center position-relative\">\n";
    $code .= "\t\t<span class=\"card-badge bg-secondary absolute float-right opacity-1 \">{$count}</span>\n";
    $code .= "<div class=\"row w-100 p-0 m-0\">\n";
    $code .= "<div class=\"col-12 d-flex align-items-center justify-content-center\">\n";
    $code .= "<a href=\"/tdp/sectors/home/{$diagnostic['diagnostic']}\" class=\"stretched-link\">\n";
    $code .= "\t\t\t\t\t\t<canvas id=\"heatGraph-{$diagnostic['diagnostic']}\" class=\"heatgraph-canvas\" height=\"254px\" data-type=\"Diagnostico\" data-title=\"$title\"  data-subtitle=\"$subtitle\" data-percentage=\"$percentage\"></canvas>\n";
    $code .= "</a>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "\t</div>\n";
}
$code .= "</div>\n";

$title = $strings->get_Striptags($line["name"]);
$message = $strings->get_Striptags($line["description"]);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Diagnostics.tdp-list-title'),
    "header-back" => $back,
    //"header-add" => '/tdp/diagnostics/create/' . $oid,
    "header-list" => '/tdp/diagnostics/list/' . $oid,
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
    "alert" => array('type' => 'secondary', 'title' => lang("Diagnostics.tdp-diagnostic-info-title"), 'message' => lang("Diagnostics.tdp-diagnostic-info-message"), 'class' => 'mb-0'),
));
echo($info);
?>