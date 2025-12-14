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
// $oid Recibe el "Component"
$component = $mcomponents->get_Component($oid);
if (!$component) {
    $category = $mcategories->get_Category($oid);
    $component = $mcomponents->get_Component($category["component"]);
}

$diagnostic = $mdiagnostics->get_Diagnostic($component["diagnostic"]);
$requirement = $mrequirements->get_Requirement($diagnostic["requirement"]);

$component_name = $strings->get_Striptags($component["name"]);
$diagnostic_name = $strings->get_Striptags($diagnostic["name"]);
$requirement_name = $strings->get_Striptags($requirement["name"]);


$links['requirements'] = $bootstrap->get_A("link-$oid", array('href' => "/iso9001/requirements/home/" . lpk(), 'content' => lang('Requirements.list-title')));
$links['diagnostics'] = $bootstrap->get_A("link-$oid", array('href' => "/iso9001/diagnostics/home/{$diagnostic["requirement"]}", 'content' => $requirement_name));
$links['components'] = $bootstrap->get_A("link-$oid", array('href' => "/iso9001/components/home/{$diagnostic["diagnostic"]}", 'content' => $diagnostic_name));
$links['categories'] = $bootstrap->get_A("link-$oid", array('href' => "/iso9001/categories/home/{$component['component']}", 'content' => $component_name));

$root = $bootstrap->get_TreeNode("2015","ISO9001");
$tree = $bootstrap->get_Tree($root);

$nrequirement = $bootstrap->get_TreeNode($links['diagnostics'],"Requerimientos");
$ndiagnostics = $bootstrap->get_TreeNode($links['components'],"Diagnosticos" );
$ncomponents = $bootstrap->get_TreeNode($links['categories'],"Componentes" );
$ncategories = $bootstrap->get_TreeNode("Categorías");

$root->addChild($nrequirement);
$nrequirement->addChild($ndiagnostics);
$ndiagnostics->addChild($ncomponents);
//$ncomponents->addChild($ncategories);

$render = $tree->render();
//[widget]--------------------------------------------------------------------------------------------------------------
$widget = $bootstrap->get_Card("card-view-service", array(
    "title" => "Ruta",
    "content" => $render,
    "body-class" => "py-0 px-0",
));
echo($widget);
?>