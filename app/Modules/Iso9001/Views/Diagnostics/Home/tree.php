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

/* @$oid Recibe el "Requerimiento" */
$bootstrap = service('bootstrap');
$strings = service('strings');
//[models]--------------------------------------------------------------------------------------------------------------
$mrequirements = model('App\Modules\Iso9001\Models\Iso9001_Requirements');
$mdiagnostics = model('App\Modules\Iso9001\Models\Iso9001_Diagnostics');
// $oid Recibe el "Requerimiento"


$requirement = $mrequirements->get_Requirement($oid);

if (!$requirement) {
    $diagnostic = $mdiagnostics->get_Diagnostic($oid);
    $requirement = $mrequirements->get_Requirement($diagnostic['requirement']);
}

$name = $strings->get_Striptags($requirement["name"]);

$links['requirements'] = $bootstrap->get_A("link-$oid", array('href' => "/iso9001/requirements/home/" . lpk(), 'content' => lang('Requirements.list-title')));
$links['requirement'] = $bootstrap->get_A("link-$oid", array('href' => "/iso9001/diagnostics/home/$oid", 'content' => $name));


$root = $bootstrap->get_TreeNode("2015","ISO9001");
$tree = $bootstrap->get_Tree($root);

$nrequirement = $bootstrap->get_TreeNode($links['requirement'],"Requerimientos");
//$ndiagnostics = $bootstrap->get_TreeNode($links['components'],"Diagnosticos" );
//$ncomponents = $bootstrap->get_TreeNode($links['categories'],"Componentes" );
//$ncategories = $bootstrap->get_TreeNode("Categorías");

$root->addChild($nrequirement);
//$nrequirement->addChild($ndiagnostics);
//$ndiagnostics->addChild($ncomponents);
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