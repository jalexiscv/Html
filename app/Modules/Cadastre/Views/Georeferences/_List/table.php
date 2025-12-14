<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-11-10 06:42:23
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Georeferences\List\table.php]
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
$b = service("bootstrap");
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/cadastre";
$table = array(
    'id' => 'table-' . lpk(),
    'data-url' => '/cadastre/api/georeferences/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('icon' => ICON_ADD, 'text' => lang('App.Create'), 'href' => '/cadastre/georeferences/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'georeference' => array('text' => lang('App.georeference'), 'class' => 'text-center'),
        'profile' => array('text' => lang('App.profile'), 'class' => 'text-center'),
        'latitud' => array('text' => lang('App.latitud'), 'class' => 'text-center'),
        'latitude_degrees' => array('text' => lang('App.latitude_degrees'), 'class' => 'text-center'),
        'latitude_minutes' => array('text' => lang('App.latitude_minutes'), 'class' => 'text-center'),
        'latitude_seconds' => array('text' => lang('App.latitude_seconds'), 'class' => 'text-center'),
        'latitude_decimal' => array('text' => lang('App.latitude_decimal'), 'class' => 'text-center'),
        'longitude' => array('text' => lang('App.longitude'), 'class' => 'text-center'),
        'longitude_degrees' => array('text' => lang('App.longitude_degrees'), 'class' => 'text-center'),
        'longitude_minutes' => array('text' => lang('App.longitude_minutes'), 'class' => 'text-center'),
        'longitude_seconds' => array('text' => lang('App.longitude_seconds'), 'class' => 'text-center'),
        'longitude_decimal' => array('text' => lang('App.longitude_decimal'), 'class' => 'text-center'),
        'date' => array('text' => lang('App.date'), 'class' => 'text-center'),
        'time' => array('text' => lang('App.time'), 'class' => 'text-center'),
        'author' => array('text' => lang('App.author'), 'class' => 'text-center'),
        'created_at' => array('text' => lang('App.created_at'), 'class' => 'text-center'),
        'updated_at' => array('text' => lang('App.updated_at'), 'class' => 'text-center'),
        'deleted_at' => array('text' => lang('App.deleted_at'), 'class' => 'text-center'),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 10,
    'data-side-pagination' => 'server'
);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("card-view-service", array(
    "title" => lang('Georeferences.list-title'),
    "header-back" => $back,
    "table" => $table,
));
echo($card);
?>
