<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-07-17 08:23:09
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Journalists\Views\Journalists\List\table.php]
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
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/journalists";
$table = $bootstrap->get_DynamicTable(array(
    'id' => 'table-' . lpk(),
    'data-url' => '/journalists/api/journalists/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('icon' => ICON_ADD, 'text' => lang('App.Create'), 'href' => '/journalists/journalists/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'journalist' => array('text' => lang('App.Journalist'), 'class' => 'text-center'),
        'citizenshipcard' => array('text' => lang('App.Citizenshipcard'), 'class' => 'text-center'),
        'firstname' => array('text' => lang('App.Firstname'), 'class' => 'text-center', 'visible' => false),
        'lastname' => array('text' => lang('App.Lastname'), 'class' => 'text-center', 'visible' => false),
        'photo' => array('text' => lang('App.Photo'), 'class' => 'text-center'),
        'details' => array('text' => lang('App.Details'), 'class' => 'text-left'),
        'email' => array('text' => lang('App.Email'), 'class' => 'text-center', 'visible' => false),
        'phone' => array('text' => lang('App.Phone'), 'class' => 'text-center', 'visible' => false),
        'media' => array('text' => lang('App.Media'), 'class' => 'text-center', 'visible' => false),
        'date' => array('text' => lang('App.Date'), 'class' => 'text-center', 'visible' => false),
        'time' => array('text' => lang('App.Time'), 'class' => 'text-center', 'visible' => false),
        'status' => array('text' => lang('App.Status'), 'class' => 'text-center'),
        'position' => array('text' => lang('App.position'), 'class' => 'text-center'),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 1000,
    'data-side-pagination' => 'server'
));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Journalists_Journalists.list-title'),
    "header-back" => $back,
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Journalists_Journalists.list-title'), "message" => lang('Journalists_Journalists.list-description')),
    "content" => $table,
));
echo($card);
?>
