<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-01-18 01:19:57
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Crm\Views\Agents\List\table.php]
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
 **/

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/crm";
$table = $bootstrap->get_DynamicTable(array(
    'id' => 'table-' . lpk(),
    'data-url' => '/crm/api/agents/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('icon' => ICON_ADD, 'text' => lang('App.Create'), 'href' => '/crm/agents/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'agent' => array('text' => lang('App.Agent'), 'class' => 'text-center'),
        'reference' => array('text' => lang('App.Reference'), 'class' => 'text-center'),
        'name' => array('text' => lang('App.Name'), 'class' => 'text-center'),
        'description' => array('text' => lang('App.description'), 'class' => 'text-center', 'visible' => false),
        'image' => array('text' => lang('App.image'), 'class' => 'text-center', 'visible' => false),
        'capacity' => array('text' => lang('App.capacity'), 'class' => 'text-center', 'visible' => false),
        'morning_shift_start' => array('text' => lang('App.morning_shift_start'), 'class' => 'text-center', 'visible' => false),
        'morning_shift_end' => array('text' => lang('App.morning_shift_end'), 'class' => 'text-center', 'visible' => false),
        'afternoon_shift_start' => array('text' => lang('App.afternoon_shift_start'), 'class' => 'text-center', 'visible' => false),
        'afternoon_shift_end' => array('text' => lang('App.afternoon_shift_end'), 'class' => 'text-center', 'visible' => false),
        'author' => array('text' => lang('App.author'), 'class' => 'text-center', 'visible' => false),
        'created_at' => array('text' => lang('App.created_at'), 'class' => 'text-center', 'visible' => false),
        'updated_at' => array('text' => lang('App.updated_at'), 'class' => 'text-center', 'visible' => false),
        'deleted_at' => array('text' => lang('App.deleted_at'), 'class' => 'text-center', 'visible' => false),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 10,
    'data-side-pagination' => 'server'
));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Agents.list-title'),
    "header-back" => $back,
    "content" => $table,
));
echo($card);
?>
