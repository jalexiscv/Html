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
 *  ** █ @authentication, @request, @dates, @parent, @program, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$strings = service("strings");
$mdiagnostics = model('App\Modules\Tdp\Models\Tdp_Diagnostics');
$msectors = model('App\Modules\Tdp\Models\Tdp_Sectors');
$mprograms = model('App\Modules\Tdp\Models\Tdp_Programs');
$mproducts = model('App\Modules\Tdp\Models\Tdp_Products');
//[vars]----------------------------------------------------------------------------------------------------------------
//Recibe el programa $oid
$program = $mprograms->get_Program($oid);
$products = $mproducts->where("program", $oid)->findAll();
$back = "/tdp/programs/home/{$program["sector"]}";

$code = "<div class=\"row\trow-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1\ttext-center shortcuts\">\n";
$count = 0;
foreach ($products as $product) {
    $count++;
    $score = $mproducts->get_Score($product['product']);
    $percentage = $score;
    $title = $product['name'];
    $subtitle = "$percentage%";
    $code .= "\t\t<div class=\"col mb-1\">\n";
    $code .= "<div class=\"card mb-1\">\n";
    $code .= "\t<div class=\"card-body d-flex align-items-center position-relative\">\n";
    $code .= "\t\t<span class=\"card-badge bg-secondary absolute float-right opacity-1 \">{$count}</span>\n";
    $code .= "<div class=\"row w-100 p-0 m-0\">\n";
    $code .= "<div class=\"col-12 d-flex align-items-center justify-content-center\">\n";
    $code .= "<a href=\"/tdp/indicators/home/{$product['product']}\" class=\"stretched-link\">\n";
    $code .= "\t\t\t\t\t\t<canvas id=\"heatGraph-{$product['product']}\" class=\"heatgraph-canvas\" height=\"254px\" data-type=\"Producto\" data-title=\"$title\" data-subtitle=\"$subtitle\" data-percentage=\"$percentage\"></canvas>\n";
    $code .= "</a>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "</div>\n";
    $code .= "\t</div>\n";
}
$code .= "</div>\n";

$title = $strings->get_Clear($program["name"]);
$message = $strings->get_Clear($program["description"]);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => sprintf(lang('Products.tdp-list-title'), ""),
    "header-back" => $back,
    "header-list" => '/tdp/products/list/' . $oid,
    "alert" => array(
        'type' => 'info',
        'title' => $title,
        'message' => $message
    ),
    "content" => $code,
));
echo($card);
?>