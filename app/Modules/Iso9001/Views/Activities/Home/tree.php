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

/* @$oid Recibe el "Component" */
$bootstrap = service('bootstrap');
$strings = service('strings');
//[models]--------------------------------------------------------------------------------------------------------------
$mrequirements = model('App\Modules\Iso9001\Models\Iso9001_Requirements');
$mdiagnostics = model('App\Modules\Iso9001\Models\Iso9001_Diagnostics');
$mcomponents = model('App\Modules\Iso9001\Models\Iso9001_Components');
$mcategories = model('App\Modules\Iso9001\Models\Iso9001_Categories');
$mactivities = model('App\Modules\Iso9001\Models\Iso9001_Activities');
// $oid Recibe el "Requerimiento"
$category = $mcategories->get_Category($oid);
if (!$category) {
    $activity = $mactivities->getActivity($oid);
    $category = $mcategories->get_Category($activity["category"]);
}


$component = $mcomponents->get_Component($category["component"]);
$diagnostic = $mdiagnostics->get_Diagnostic($component["diagnostic"]);
$requirement = $mrequirements->get_Requirement($diagnostic["requirement"]);

$category_name = $strings->get_Striptags($category["name"]);
$component_name = $strings->get_Striptags($component["name"]);
$diagnostic_name = $strings->get_Striptags($diagnostic["name"]);
$requirement_name = $strings->get_Striptags($requirement["name"]);

$links['requirements'] = $bootstrap->get_A("link-$oid", array('href' => "/iso9001/requirements/home/" . lpk(), 'content' => lang('Requirements.list-title')));
$links['diagnostics'] = $bootstrap->get_A("link-$oid", array('href' => "/iso9001/diagnostics/home/{$diagnostic["requirement"]}", 'content' => $requirement_name));
$links['components'] = $bootstrap->get_A("link-$oid", array('href' => "/iso9001/components/home/{$diagnostic["diagnostic"]}", 'content' => $diagnostic_name));
$links['categories'] = $bootstrap->get_A("link-$oid", array('href' => "/iso9001/categories/home/{$component['component']}", 'content' => $component_name));
$links['activities'] = $bootstrap->get_A("link-$oid", array('href' => "/iso9001/activities/home/{$category['category']}", 'content' => $category_name));

$root = $bootstrap->get_TreeNode("2015","ISO9001");
$tree = $bootstrap->get_Tree($root);

$nrequirement = $bootstrap->get_TreeNode($links['diagnostics'],"Requerimiento");
$ndiagnostics = $bootstrap->get_TreeNode($links['components'],"Diagnostico");
$ncomponents = $bootstrap->get_TreeNode($links['categories'],"Componente");
$ncategory = $bootstrap->get_TreeNode($links['activities'],"Categoría");
$nactivities = $bootstrap->get_TreeNode("Actividades","Actividades");

$root->addChild($nrequirement);
$nrequirement->addChild($ndiagnostics);
$ndiagnostics->addChild($ncomponents);
$ncomponents->addChild($ncategory);
//$ncategory->addChild($nactivities);

$render = $tree->render();
//[widget]--------------------------------------------------------------------------------------------------------------
$widget = $bootstrap->get_Card("card-view-service", array(
    "title" => "Ruta",
    "content" => $render,
    "body-class" => "py-0 px-0",
));
echo($widget);
?>