<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-30 18:04:58
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Social\Views\Posts\List\table.php]
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
$back = "/social";
$table = $bootstrap->get_DynamicTable(array(
    'id' => 'table-' . lpk(),
    'data-url' => '/social/api/posts/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('icon' => ICON_ADD, 'text' => lang('App.Create'), 'href' => '/social/posts/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'post' => array('text' => lang('App.post'), 'class' => 'text-center'),
        'semantic' => array('text' => lang('App.semantic'), 'class' => 'text-center'),
        'title' => array('text' => lang('App.title'), 'class' => 'text-center'),
        'content' => array('text' => lang('App.content'), 'class' => 'text-center'),
        'type' => array('text' => lang('App.type'), 'class' => 'text-center'),
        'cover' => array('text' => lang('App.cover'), 'class' => 'text-center'),
        'cover_visible' => array('text' => lang('App.cover_visible'), 'class' => 'text-center'),
        'description' => array('text' => lang('App.description'), 'class' => 'text-center'),
        'date' => array('text' => lang('App.date'), 'class' => 'text-center'),
        'time' => array('text' => lang('App.time'), 'class' => 'text-center'),
        'country' => array('text' => lang('App.country'), 'class' => 'text-center'),
        'region' => array('text' => lang('App.region'), 'class' => 'text-center'),
        'city' => array('text' => lang('App.city'), 'class' => 'text-center'),
        'latitude' => array('text' => lang('App.latitude'), 'class' => 'text-center'),
        'longitude' => array('text' => lang('App.longitude'), 'class' => 'text-center'),
        'author' => array('text' => lang('App.author'), 'class' => 'text-center'),
        'created_at' => array('text' => lang('App.created_at'), 'class' => 'text-center'),
        'updated_at' => array('text' => lang('App.updated_at'), 'class' => 'text-center'),
        'deleted_at' => array('text' => lang('App.deleted_at'), 'class' => 'text-center'),
        'views' => array('text' => lang('App.views'), 'class' => 'text-center'),
        'views_initials' => array('text' => lang('App.views_initials'), 'class' => 'text-center'),
        'viewers' => array('text' => lang('App.viewers'), 'class' => 'text-center'),
        'likes' => array('text' => lang('App.likes'), 'class' => 'text-center'),
        'shares' => array('text' => lang('App.shares'), 'class' => 'text-center'),
        'comments' => array('text' => lang('App.comments'), 'class' => 'text-center'),
        'video' => array('text' => lang('App.video'), 'class' => 'text-center'),
        'source' => array('text' => lang('App.source'), 'class' => 'text-center'),
        'source_alias' => array('text' => lang('App.source_alias'), 'class' => 'text-center'),
        'verified' => array('text' => lang('App.verified'), 'class' => 'text-center'),
        'status' => array('text' => lang('App.status'), 'class' => 'text-center'),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 10,
    'data-side-pagination' => 'server'
));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Posts.list-title'),
    "header-back" => $back,
    "content" => $table,
));
echo($card);
?>
