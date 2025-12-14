<?php
/*
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-12-01 23:19:27
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 */
/* @$oid Recibe el "Component" */
$bootstrap = service('bootstrap');
$strings = service('strings');
//[models]--------------------------------------------------------------------------------------------------------------
$mdimensions = model('App\Modules\Mipg\Models\Mipg_Dimensions');
$mpolitics = model('App\Modules\Mipg\Models\Mipg_Politics');
$mdiagnostics = model('App\Modules\Mipg\Models\Mipg_Diagnostics');
$mcomponents = model('App\Modules\Mipg\Models\Mipg_Components');
$mcategories = model('App\Modules\Mipg\Models\Mipg_Categories');
$mactivities = model('App\Modules\Mipg\Models\Mipg_Activities');
$mplans = model('App\Modules\Mipg\Models\Mipg_Plans');

// $oid Recibe  "plan"
$plan = $mplans->getPlan($oid);
$activity = $mactivities->get_Activity($plan["activity"]);
$category = $mcategories->get_Category($activity["category"]);
$component = $mcomponents->get_Component($category['component']);
$diagnostic = $mdiagnostics->get_Diagnostic($component['diagnostic']);
$politic = $mpolitics->get_Politic($diagnostic['politic']);
$dimension = $mdimensions->get_Dimension($politic['dimension']);

$name_activity = $strings->get_Striptags($activity["description"]);
$name_category = $strings->get_Striptags($category["name"]);
$name_component = $strings->get_Striptags($component["name"]);
$name_diagnostic = $strings->get_Striptags($diagnostic["name"]);
$name_politic = $strings->get_Striptags($politic["name"]);
$name_dimension = $strings->get_Striptags($dimension["name"]);

$links['dimension'] = $bootstrap->get_A("link-$oid", array('href' => "/mipg/politics/home/{$dimension['dimension']}", 'content' => $name_dimension));
$links['politic'] = $bootstrap->get_A("link-$oid", array('href' => "/mipg/diagnostics/home/{$politic['politic']}", 'content' => $name_politic));
$links['diagnostic'] = $bootstrap->get_A("link-$oid", array('href' => "/mipg/components/home/{$diagnostic['diagnostic']}", 'content' => $name_diagnostic));
$links['component'] = $bootstrap->get_A("link-$oid", array('href' => "/mipg/categories/home/{$component['component']}", 'content' => $name_component));
$links['categories'] = $bootstrap->get_A("link-$oid", array('href' => "/mipg/activities/home/$oid", 'content' => $name_category));
$links['activity'] = $bootstrap->get_A("link-$oid", array('href' => "/mipg/plans/home/{$activity['activity']}", 'content' => $name_activity));


$ndimension = $bootstrap->get_TreeNode($links['dimension'], "Dimensión");
$npolitic = $bootstrap->get_TreeNode($links['politic'], "Política");
$ndiagnostic = $bootstrap->get_TreeNode($links['diagnostic'], "Diagnóstico");
$ncomponent = $bootstrap->get_TreeNode($links['component'], "Componente");
$ncategory = $bootstrap->get_TreeNode($links['categories'], "Categoría");
$nactivity = $bootstrap->get_TreeNode($links['activity'], "Actividad");

$tree = $bootstrap->get_Tree($ndimension);
$ndimension->addChild($npolitic);
$npolitic->addChild($ndiagnostic);
$ndiagnostic->addChild($ncomponent);
$ncomponent->addChild($ncategory);
$ncategory->addChild($nactivity);

//[widget-score]--------------------------------------------------------------------------------------------------------
$widget_score = $bootstrap->get_Score(array(
    "title" => lang('App.Activity'),
    "value" => $mactivities->get_Score($activity['activity']),
    "description" => "Valoración",
));
echo($widget_score);
//[widget-path]---------------------------------------------------------------------------------------------------------
$widget_tree = $bootstrap->get_Card("card-view-service", array(
    "title" => "Ruta",
    "content" => $tree->render(),
    "body-class" => "py-0 px-0",
));
echo($widget_tree);
?>