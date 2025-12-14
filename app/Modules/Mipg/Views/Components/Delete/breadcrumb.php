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

$mdimensions = model('App\Modules\Mipg\Models\Mipg_Dimensions');
$mpolitics = model('App\Modules\Mipg\Models\Mipg_Politics');
$mdiagnostics = model('App\Modules\Mipg\Models\Mipg_Diagnostics');
$mcomponents = model('App\Modules\Mipg\Models\Mipg_Components');


$component = $mcomponents->where("component", $oid)->first();
$diagnostic = $mdiagnostics->where("diagnostic", $component['diagnostic'])->first();
$politic = $mpolitics->where("politic", $diagnostic['politic'])->first();
$dimension = $mdimensions->where("dimension", $politic['dimension'])->first();

$menu = array(
    array("href" => "/mipg/", "text" => "Inicio", "class" => false),
    array("href" => "/mipg/dimensions/home/" . lpk(), "text" => lang("App.Dimensions"), "class" => false),
    array("href" => "/mipg/politics/home/{$politic['dimension']}", "text" => lang("App.Politics"), "class" => false),
    array("href" => "/mipg/diagnostics/home/{$diagnostic['politic']}", "text" => lang("App.Diagnostics"), "class" => false),
    array("href" => "/mipg/components/home/{$oid}", "text" => $diagnostic['name'], "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>