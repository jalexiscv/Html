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
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$strings = service("strings");
//[models]----------------------------------------------------------------------------------------------------------------
//Recibe el category $oid
$mdiagnostics = model('App\Modules\Mipg\Models\Mipg_Diagnostics');
$mcomponents = model('App\Modules\Mipg\Models\Mipg_Components');
$mcategories = model('App\Modules\Mipg\Models\Mipg_Categories');
$mactivities = model('App\Modules\Mipg\Models\Mipg_Activities');
//[vars]----------------------------------------------------------------------------------------------------------------
$category = $mcategories->where("category", $oid)->first();

$back = "/mipg/activities/home/{$oid}";
$table = $bootstrap->get_DynamicTable(array(
    'id' => 'table-' . lpk(),
    'data-url' => "/mipg/api/activities/json/list/{$oid}",
    'buttons' => array(
        'create' => array('icon' => ICON_ADD, 'text' => lang('App.Create'), 'href' => "/mipg/activities/create/{$oid}", 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'activity' => array('text' => lang('App.Activity'), 'class' => 'text-center', 'visible' => false),
        'category' => array('text' => lang('App.Category'), 'class' => 'text-center', 'visible' => false),
        'order' => array('text' => lang('App.Order'), 'class' => 'text-center'),
        'criteria' => array('text' => lang('App.Criteria'), 'class' => 'text-center', 'visible' => false),
        'description' => array('text' => lang('App.Description'), 'class' => 'text-start'),
        'evaluation' => array('text' => lang('App.Evaluation'), 'class' => 'text-center', 'visible' => false),
        'period' => array('text' => lang('App.Period'), 'class' => 'text-center', 'visible' => false),
        'score' => array('text' => lang('App.Score'), 'class' => 'text-center', 'visible' => false),
        'author' => array('text' => lang('App.Author'), 'class' => 'text-center', 'visible' => false),
        'created_at' => array('text' => lang('App.Created_at'), 'class' => 'text-center', 'visible' => false),
        'updated_at' => array('text' => lang('App.Updated_at'), 'class' => 'text-center', 'visible' => false),
        'deleted_at' => array('text' => lang('App.Deleted_at'), 'class' => 'text-center', 'visible' => false),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 100,
    'data-side-pagination' => 'server'
));

$title = $strings->get_Clear($category["name"]);
$message = $strings->get_Clear($category["description"]);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Mipg_Activities.list-title'),
    "header-back" => $back,
    "alert" => array(
        'type' => 'info',
        'title' => $title,
        'message' => $message
    ),
    "content" => $table,
));
echo($card);
?>