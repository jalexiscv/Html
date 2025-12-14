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
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mdimensions = model('App\Modules\Tdp\Models\Tdp_Dimensions');
$mlines = model('App\Modules\Tdp\Models\Tdp_Lines');
$mdiagnostics = model('App\Modules\Tdp\Models\Tdp_Diagnostics');
$msectors = model('App\Modules\Tdp\Models\Tdp_Sectors');
$mprograms = model('App\Modules\Tdp\Models\Tdp_Programs');
$mproducts = model('App\Modules\Tdp\Models\Tdp_Products');
// $oid Recibe la "Component"
$sector = $msectors->get_Sector($oid);
if (!$sector) {
    $program = $mprograms->get_Program($oid);
    $sector = $msectors->get_Sector($program['sector']);
}
$diagnostic = $mdiagnostics->get_Diagnostic($sector['diagnostic']);
$line = $mlines->get_Line($diagnostic['line']);
$dimension = $mdimensions->get_Dimension($line['dimension']);

$name_sector = $strings->get_Striptags($sector["name"]);
$name_diagnostic = $strings->get_Striptags($diagnostic["name"]);
$name_line = $strings->get_Striptags($line["name"]);
$name_dimension = $strings->get_Striptags($dimension["name"]);

$menu = array(
    array("href" => "/tdp/", "text" => "TDP", "class" => false),
    array("href" => "/tdp/dimensions/home/", "text" => lang("App.Dimensions"), "class" => false),
    array("href" => "/tdp/lines/home/{$dimension['dimension']}", "text" => $name_dimension, "class" => false),
    array("href" => "/tdp/diagnostics/home/{$line['line']}", "text" => $name_line, "class" => false),
    array("href" => "/tdp/sectors/home/{$diagnostic['diagnostic']}", "text" => $name_diagnostic, "class" => false),
    array("href" => "/tdp/programs/home/$oid", "text" => $name_sector, "class" => false),
    array("href" => "/tdp/programs/home/$oid", "text" => lang("App.Programs"), "class" => false),
);
echo($bootstrap->get_Breadcrumb($menu));
?>