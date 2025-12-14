<?php

/**
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-04-08 16:26:12
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Organization\Views\Positions\Creator\deny.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ -------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ -------------------------------------------------------------------------------------------------------------------
 **/
$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$mmacroproceses = model('App\Modules\Organization\Models\Organization_Macroprocesses');
$mprocesses = model('App\Modules\Organization\Models\Organization_Processes');
$msubprocesses = model('App\Modules\Organization\Models\Organization_Subprocesses');
$mpositions = model('App\Modules\Organization\Models\Organization_Positions');
//[vars]----------------------------------------------------------------------------------------------------------------
$position = $mpositions->get_Position($oid);
$subprocess = (!$position) ? $msubprocesses->get_Subprocess($oid) : $msubprocesses->get_Subprocess($position['subprocess']);
$process = $mprocesses->get_Process($subprocess['process']);
$macroprocess = $mmacroproceses->get_Macroprocess($process['macroprocess']);
//[build]---------------------------------------------------------------------------------------------------------------
$menu = array(
    array("href" => "/organization/", "text" => lang("App.Organization"), "class" => false),
    array("href" => "/organization/macroprocesses/list/" . lpk(), "text" => lang("App.Macroprocess"), "class" => false),
    array("href" => "/organization/processes/list/{$macroprocess['macroprocess']}", "text" => lang("App.Process"), "class" => false),
    array("href" => "/organization/subprocesses/list/{$process['process']}", "text" => lang("App.Subprocess"), "class" => false),
    array("href" => "/organization/positions/list/{$subprocess['subprocess']}", "text" => lang("App.Positions"), "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>