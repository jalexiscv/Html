<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-05 03:52:47
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Organization\Views\Plans\List\table.php]
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
 * █ @var object $parent
 * █ @var object $authentication
 * █ @var object $request
 * █ @var object $dates
 * █ @var string $component
 * █ @var string $view
 * █ @var string $oid
 * █ @var string $views
 * █ @var string $prefix
 * █ @var array $data
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/organization";
$table = $bootstrap->get_DynamicTable(array(
    'id' => 'table-' . lpk(),
    'data-url' => '/organization/api/plans/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('icon' => ICON_ADD, 'text' => lang('App.Create'), 'href' => '/organization/plans/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'plan' => array('text' => lang('App.Plan'), 'class' => 'text-center', 'visible' => false),
        'reference' => array('text' => lang('App.Reference'), 'class' => 'text-center'),
        'name' => array('text' => lang('App.Name'), 'class' => 'text-start'),
        'description' => array('text' => lang('App.description'), 'class' => 'text-center', 'visible' => false),
        'author' => array('text' => lang('App.author'), 'class' => 'text-center', 'visible' => false),
        'created_at' => array('text' => lang('App.created_at'), 'class' => 'text-center', 'visible' => false),
        'updated_at' => array('text' => lang('App.updated_at'), 'class' => 'text-center', 'visible' => false),
        'deleted_at' => array('text' => lang('App.deleted_at'), 'class' => 'text-center', 'visible' => false),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 100,
    'data-side-pagination' => 'server'
));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Plans.organization-plans-list-title'),
    "alert" => array(
        "icon" => ICON_INFO,
        "type" => "info",
        "title" => "¡Atención!",
        "message" => lang('Plans.organization-plans-list-alert'),
        "class" => "alert-warning"
    ),
    "header-back" => $back,
    "content" => $table,
));
echo($card);
?>
