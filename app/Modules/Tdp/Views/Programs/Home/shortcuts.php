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
 *  ** █ @authentication, @request, @dates, @parent, @sector, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$strings = service("strings");
$mdiagnostics = model('App\Modules\Tdp\Models\Tdp_Diagnostics');
$diagnostics = $mdiagnostics->where("line", $oid)->findAll();
//[vars]----------------------------------------------------------------------------------------------------------------
//Recibe el sectore $oid
$mdiagnostics = model('App\Modules\Tdp\Models\Tdp_Diagnostics');
$msectors = model('App\Modules\Tdp\Models\Tdp_Sectors');
$mprograms = model('App\Modules\Tdp\Models\Tdp_Programs');
$sector = $msectors->where("sector", $oid)->first();
$programs = $mprograms->where("sector", $oid)->findAll();
$back = "/tdp/sectors/home/{$sector["diagnostic"]}";

$code = "<div class=\"row\trow-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1\ttext-center shortcuts\">\n";
$count = 0;
foreach ($programs as $categorie) {
    $count++;
    $score = $mprograms->get_Score($categorie['program']);
    $percentage = $score;
    $title = $categorie['name'];
    $subtitle = "$percentage%";
    $code .= "\t\t<div class=\"col mb-1\">\n";
    $code .= "<div class=\"card mb-1\">\n";
    $code .= "\t<div class=\"card-body d-flex align-items-center position-relative\">\n";
    $code .= "\t\t<span class=\"card-badge bg-secondary absolute float-right opacity-1 \">{$count}</span>\n";
    $code .= "<div class=\"row w-100 p-0 m-0\">\n";
    $code .= "<div class=\"col-12 d-flex align-items-center justify-content-center\">\n";
    $code .= "<a href=\"/tdp/products/home/{$categorie['program']}\" class=\"stretched-link\">\n";
    $code .= "\t\t\t\t\t\t<canvas id=\"heatGraph-{$categorie['program']}\" class=\"heatgraph-canvas\" height=\"254px\" data-type=\"Programa\" data-title=\"$title\" data-subtitle=\"$subtitle\" data-percentage=\"$percentage\"></canvas>\n";
    $code .= "</a>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "\t</div>\n";
}
$code .= "</div>\n";

$title = $strings->get_Clear($sector["name"]);
$message = $strings->get_Clear($sector["description"]);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => sprintf(lang('Programs.tdp-list-title'), ""),
    "header-back" => $back,
    "header-list" => '/tdp/programs/list/' . $oid,
    "alert" => array(
        'type' => 'info',
        'title' => $title,
        'message' => $message
    ),
    "content" => $code,
));
echo($card);
?>