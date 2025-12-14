<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-01-14 23:31:22
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Publisher\Views\Sites\List\table.php]
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
$back = "/publisher";
$table = $bootstrap->get_DynamicTable(array(
    'id' => 'table-' . lpk(),
    'data-url' => '/publisher/api/sites/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('icon' => ICON_ADD, 'text' => lang('App.Create'), 'href' => '/publisher/sites/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'site' => array('text' => lang('App.Site'), 'class' => 'text-center'),
        'image' => array('text' => lang('App.Image'), 'class' => 'text-center', 'visible' => false),
        'name' => array('text' => lang('App.Name'), 'class' => 'text-center'),
        'description' => array('text' => lang('App.description'), 'class' => 'text-center', 'visible' => false),
        'max_links' => array('text' => lang('App.max_links'), 'class' => 'text-center', 'visible' => false),
        'links_type' => array('text' => lang('App.links_type'), 'class' => 'text-center', 'visible' => false),
        'sponsored' => array('text' => lang('App.sponsored'), 'class' => 'text-center', 'visible' => false),
        'post_cover' => array('text' => lang('App.post_cover'), 'class' => 'text-center', 'visible' => false),
        'categories' => array('text' => lang('App.categories'), 'class' => 'text-center', 'visible' => false),
        'min_traffic' => array('text' => lang('App.min_traffic'), 'class' => 'text-center', 'visible' => false),
        'max_traffic' => array('text' => lang('App.max_traffic'), 'class' => 'text-center', 'visible' => false),
        'type' => array('text' => lang('App.type'), 'class' => 'text-center', 'visible' => false),
        'themes' => array('text' => lang('App.themes'), 'class' => 'text-center', 'visible' => false),
        'moz_da' => array('text' => lang('App.moz_da'), 'class' => 'text-center', 'visible' => false),
        'moz_pa' => array('text' => lang('App.moz_pa'), 'class' => 'text-center', 'visible' => false),
        'moz_links' => array('text' => lang('App.moz_links'), 'class' => 'text-center', 'visible' => false),
        'moz_rank' => array('text' => lang('App.moz_rank'), 'class' => 'text-center', 'visible' => false),
        'majestic_cf' => array('text' => lang('App.majestic_cf'), 'class' => 'text-center', 'visible' => false),
        'majestic_tf' => array('text' => lang('App.majestic_tf'), 'class' => 'text-center', 'visible' => false),
        'majestic_links' => array('text' => lang('App.majestic_links'), 'class' => 'text-center', 'visible' => false),
        'majestic_rd' => array('text' => lang('App.majestic_rd'), 'class' => 'text-center', 'visible' => false),
        'ahrefs_dr' => array('text' => lang('App.ahrefs_dr'), 'class' => 'text-center', 'visible' => false),
        'ahrefs_bl' => array('text' => lang('App.ahrefs_bl'), 'class' => 'text-center', 'visible' => false),
        'ahrefs_rd' => array('text' => lang('App.ahrefs_rd'), 'class' => 'text-center', 'visible' => false),
        'ahrefs_obl' => array('text' => lang('App.ahrefs_obl'), 'class' => 'text-center', 'visible' => false),
        'ahrefs_otm' => array('text' => lang('App.ahrefs_otm'), 'class' => 'text-center', 'visible' => false),
        'sistrix' => array('text' => lang('App.sistrix'), 'class' => 'text-center', 'visible' => false),
        'price' => array('text' => lang('App.price'), 'class' => 'text-center', 'visible' => false),
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
    "title" => lang('Sites.list-title'),
    "header-back" => $back,
    "content" => $table,
));
echo($card);
?>
