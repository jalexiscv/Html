<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-05 12:35:17
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Evaluations\List\table.php]
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
$back = "/sie";
$table = $bootstrap->get_DynamicTable(array(
    'id' => 'table-' . lpk(),
    'data-url' => '/sie/api/evaluations/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('icon' => ICON_ADD, 'text' => lang('App.Create'), 'href' => '/sie/evaluations/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'evaluation' => array('text' => lang('App.evaluation'), 'class' => 'text-center'),
        'type' => array('text' => lang('App.type'), 'class' => 'text-center'),
        'teacher' => array('text' => lang('App.teacher'), 'class' => 'text-center'),
        'q1' => array('text' => lang('App.q1'), 'class' => 'text-center'),
        'q2' => array('text' => lang('App.q2'), 'class' => 'text-center'),
        'q3' => array('text' => lang('App.q3'), 'class' => 'text-center'),
        'q4' => array('text' => lang('App.q4'), 'class' => 'text-center'),
        'q5' => array('text' => lang('App.q5'), 'class' => 'text-center'),
        'q6' => array('text' => lang('App.q6'), 'class' => 'text-center'),
        'q7' => array('text' => lang('App.q7'), 'class' => 'text-center'),
        'q8' => array('text' => lang('App.q8'), 'class' => 'text-center'),
        'q9' => array('text' => lang('App.q9'), 'class' => 'text-center'),
        'q10' => array('text' => lang('App.q10'), 'class' => 'text-center'),
        'author' => array('text' => lang('App.author'), 'class' => 'text-center'),
        'date' => array('text' => lang('App.date'), 'class' => 'text-center'),
        'time' => array('text' => lang('App.time'), 'class' => 'text-center'),
        'created_at' => array('text' => lang('App.created_at'), 'class' => 'text-center'),
        'updated_at' => array('text' => lang('App.updated_at'), 'class' => 'text-center'),
        'deleted_at' => array('text' => lang('App.deleted_at'), 'class' => 'text-center'),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 10,
    'data-side-pagination' => 'server'
));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Evaluations.list-title'),
    "header-back" => $back,
    "alert" => array("icon" => ICON_INFO, "type" => "info", "title" => lang('Evaluations.list-title'), "message" => lang('Evaluations.list-description')),
    "content" => $table,
));
echo($card);
?>
