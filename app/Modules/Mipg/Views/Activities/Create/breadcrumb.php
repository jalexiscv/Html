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
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mdimensions = model('App\Modules\Mipg\Models\Mipg_Dimensions');
$mpolitics = model('App\Modules\Mipg\Models\Mipg_Politics');
$mdiagnostics = model('App\Modules\Mipg\Models\Mipg_Diagnostics');
$mcomponents = model('App\Modules\Mipg\Models\Mipg_Components');
$mcategories = model('App\Modules\Mipg\Models\Mipg_Categories');
$mactivities = model('App\Modules\Mipg\Models\Mipg_Activities');
// $oid Recibe  "Category"
$category = $mcategories->get_Category($oid);
if (!$category) {
    $activity = $mactivities->get_Activity($oid);
    $category = $mcategories->get_Category($activity["category"]);
}

$component = $mcomponents->get_Component($category['component']);
$diagnostic = $mdiagnostics->get_Diagnostic($component['diagnostic']);
$politic = $mpolitics->get_Politic($diagnostic['politic']);
$dimension = $mdimensions->get_Dimension($politic['dimension']);

$name_category = $strings->get_Striptags($category["name"]);
$name_component = $strings->get_Striptags($component["name"]);
$name_diagnostic = $strings->get_Striptags($diagnostic["name"]);
$name_politic = $strings->get_Striptags($politic["name"]);
$name_dimension = $strings->get_Striptags($dimension["name"]);

$menu = array(
    array("href" => "/mipg/", "text" => "Inicio", "class" => false),
    array("href" => "/mipg/dimensions/home/", "text" => lang("App.Dimensions"), "class" => false),
    array("href" => "/mipg/politics/home/{$dimension['dimension']}", "text" => $name_dimension, "class" => false),
    array("href" => "/mipg/diagnostics/home/{$politic['politic']}", "text" => $name_politic, "class" => false),
    array("href" => "/mipg/components/home/{$diagnostic['diagnostic']}", "text" => $name_diagnostic, "class" => false),
    array("href" => "/mipg/categories/home/$oid", "text" => $name_component, "class" => false),
    array("href" => "/mipg/categories/home/$oid", "text" => lang("App.Categories"), "class" => false),
    array("href" => "/mipg/categories/home/$oid", "text" => $name_category, "class" => true)
);
echo($bootstrap->get_Breadcrumb($menu));
?>