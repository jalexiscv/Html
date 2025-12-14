<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-06-21 20:03:01
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Cadastre\Views\Customers\List\table.php]
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
$bootstrap = service('bootstrap');
//[table]---------------------------------------------------------------------------------------------------------------
$table = $bootstrap->get_DynamicTable(array(
    'id' => 'table-' . lpk(),
    'data-url' => '/cadastre/api/customers/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('icon' => ICON_ADD, 'href' => '/cadastre/customers/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'customer' => array('text' => lang('App.Customer'), 'class' => 'text-center', 'visible' => false),
        'registration' => array('text' => lang('App.Registration'), 'class' => 'text-center'),
        'fullname' => array('text' => lang('App.Name'), 'class' => 'text-start'),
        'address' => array('text' => lang('App.PropertyAddress'), 'class' => 'text-start'),
        'date' => array('text' => lang('App.Date'), 'class' => 'text-center'),
        'time' => array('text' => lang('App.Time'), 'class' => 'text-center', 'visible' => false),
        'author' => array('text' => lang('App.Author'), 'class' => 'text-center', 'visible' => false),
        'created_at' => array('text' => lang('App.Created_at'), 'class' => 'text-center', 'visible' => false),
        'updated_at' => array('text' => lang('App.Updated_at'), 'class' => 'text-center', 'visible' => false),
        'deleted_at' => array('text' => lang('App.Deleted_at'), 'class' => 'text-center', 'visible' => false),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 50,
    'data-side-pagination' => 'server'
));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card('table-' . lpk(), array(
    'title' => lang('Customers.list-title'),
    'header-back' => "/development/home/index",
    'content' => $table,
    'class' => 'mb-3'
));
echo($card);
?>