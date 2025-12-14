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

/* @$oid Recibe el product */
$bootstrap = service('bootstrap');
$strings = service('strings');
//[models]--------------------------------------------------------------------------------------------------------------
$mdimensions = model('App\Modules\Tdp\Models\Tdp_Dimensions');
$mlines = model('App\Modules\Tdp\Models\Tdp_Lines');
$mdiagnostics = model('App\Modules\Tdp\Models\Tdp_Diagnostics');
$msectors = model('App\Modules\Tdp\Models\Tdp_Sectors');
$mprograms = model('App\Modules\Tdp\Models\Tdp_Programs');
$mproducts = model('App\Modules\Tdp\Models\Tdp_Products');
$mindicators = model('App\Modules\Tdp\Models\Tdp_Indicators');
//[request]-------------------------------------------------------------------------------------------------------------
$product = $mproducts->get_Product($oid);
$program = !$product ? $mprograms->get_Program($oid) : $mprograms->get_Program($product['program']);
$sector = $msectors->get_Sector($program['sector']);
$diagnostic = $mdiagnostics->get_Diagnostic($sector['diagnostic']);
$line = $mlines->get_Line($diagnostic['line']);
$dimension = $mdimensions->get_Dimension($line['dimension']);
//[names]---------------------------------------------------------------------------------------------------------------
$name_products = $strings->get_Striptags($product["name"]);
$name_program = $strings->get_Striptags($program["name"]);
$name_sector = $strings->get_Striptags($sector["name"]);
$name_diagnostic = $strings->get_Striptags($diagnostic["name"]);
$name_line = $strings->get_Striptags($line["name"]);
$name_dimension = $strings->get_Striptags($dimension["name"]);

$links['dimension'] = $bootstrap->get_A("link-$oid", array('href' => "/tdp/lines/home/{$dimension['dimension']}", 'content' => $name_dimension));
$links['line'] = $bootstrap->get_A("link-$oid", array('href' => "/tdp/diagnostics/home/{$line['line']}", 'content' => $name_line));
$links['diagnostic'] = $bootstrap->get_A("link-$oid", array('href' => "/tdp/sectors/home/{$diagnostic['diagnostic']}", 'content' => $name_diagnostic));
$links['sector'] = $bootstrap->get_A("link-$oid", array('href' => "/tdp/programs/home/{$sector['sector']}", 'content' => $name_sector));
$links['program'] = $bootstrap->get_A("link-$oid", array('href' => "/tdp/products/home/{$program['program']}", 'content' => $name_program));
$links['products'] = $bootstrap->get_A("link-$oid", array('href' => "#", 'content' => $name_products));

$ndimension = $bootstrap->get_TreeNode($links['dimension'], "Dimensión");
$nline = $bootstrap->get_TreeNode($links['line'], "Linea estratégica");
$ndiagnostic = $bootstrap->get_TreeNode($links['diagnostic'], "Diagnóstico");
$nsector = $bootstrap->get_TreeNode($links['sector'], "Sector");
$nprogram = $bootstrap->get_TreeNode($links['program'], "Programa");
$nproducts = $bootstrap->get_TreeNode($links['products'], "Producto");

$tree = $bootstrap->get_Tree($ndimension);
$ndimension->addChild($nline);
$nline->addChild($ndiagnostic);
$ndiagnostic->addChild($nsector);
$nsector->addChild($nprogram);
$nprogram->addChild($nproducts);

$render = $tree->render();

//[widget-score]--------------------------------------------------------------------------------------------------------
$widget_score = $bootstrap->get_Score(array(
    "title" => lang('App.Component'),
    "value" => $msectors->get_Score($oid),
    "description" => "Valoración promedio",
));
echo($widget_score);

//[widget]--------------------------------------------------------------------------------------------------------------
$widget = $bootstrap->get_Card("card-view-service", array(
    "title" => "Ruta TDP",
    "content" => $render,
    "body-class" => "py-0 px-0",
));
echo($widget);
?>