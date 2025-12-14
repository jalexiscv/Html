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

$bootstrap = service('bootstrap');
$strings = service('strings');
//[models]--------------------------------------------------------------------------------------------------------------
$mdimensions = model('App\Modules\Mipg\Models\Mipg_Dimensions');
$mpolitics = model('App\Modules\Mipg\Models\Mipg_Politics');
$mdiagnostics = model('App\Modules\Mipg\Models\Mipg_Diagnostics');
$mcomponents = model('App\Modules\Mipg\Models\Mipg_Components');
$mcategories = model('App\Modules\Mipg\Models\Mipg_Categories');
$mactivities = model('App\Modules\Mipg\Models\Mipg_Activities');

// $oid Recibe la "Politic"
$politic = $mpolitics->get_Politic($oid);
if (!$politic) {
    $diagnostic = $mdiagnostics->get_Diagnostic($oid);
    $politic = $mpolitics->get_Politic($diagnostic['politic']);
}
$dimension = $mdimensions->get_Dimension($politic['dimension']);

$name_politic = $strings->get_Striptags($politic["name"]);
$name_dimension = $strings->get_Striptags($dimension["name"]);

$links['dimension'] = $bootstrap->get_A("link-$oid", array('href' => "/mipg/politics/home/{$dimension['dimension']}", 'content' => $name_dimension));
$links['politic'] = $bootstrap->get_A("link-$oid", array('href' => "/mipg/diagnostics/home/{$politic['politic']}", 'content' => $name_politic));

$ndimension = $bootstrap->get_TreeNode($links['dimension'], "Dimensión");
$npolitic = $bootstrap->get_TreeNode($links['politic'], "Política");

$tree = $bootstrap->get_Tree($ndimension);
$ndimension->addChild($npolitic);

$render = $tree->render();

//[widget-score]--------------------------------------------------------------------------------------------------------
$widget_score = $bootstrap->get_Score(array(
    "title" => lang('App.Politic'),
    "value" => $mpolitics->get_Score($oid),
    "description" => "Valoración promedio",
));
echo($widget_score);
//[widget]--------------------------------------------------------------------------------------------------------------
$widget = $bootstrap->get_Card("card-view-service", array(
    "title" => "Ruta",
    "content" => $render,
    "body-class" => "py-0 px-0",
));
echo($widget);
?>