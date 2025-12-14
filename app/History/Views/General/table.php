<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Stats\List\table.php]
*  ╩ ╩╝╚╝╚═╝╚═╝╩╚═╝╩═╝╚═╝
* -----------------------------------------------------------------------------
* Copyright 2021 - Higgs Bigdata S.A.S., Inc. <admin@Higgs.com>
* Este archivo es parte de Higgs Bigdata Framework 7.1
* Para obtener información completa sobre derechos de autor y licencia, consulte
* la LICENCIA archivo que se distribuyó con este código fuente.
* -----------------------------------------------------------------------------
* EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
* IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
* APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
* LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
* RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
* AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
* O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
* -----------------------------------------------------------------------------
* @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
* @link https://www.Higgs.com
* @Version 1.5.0
* @since PHP 7, PHP 8
* -----------------------------------------------------------------------------
* Datos recibidos desde el controlador - @ModuleController
* -----------------------------------------------------------------------------
* @Authentication
* @request
* @dates
* @view
* @oid
* @component
* @views
* @prefix
* @parent
* -----------------------------------------------------------------------------
*/
$table = array(
    'id' => 'table-' . lpk(),
    'data-url' => '/history/api/general/json/list/' . lpk(),
    'buttons' => array(//'create' => array('text' =>lang('App.Create'), 'href' => '/application/stats/create/'.lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'stat' => array('text' => lang('App.Stat'), 'class' => 'text-center', 'visible' => false),
        'instance' => array('text' => lang('App.Instance'), 'class' => 'text-center', 'visible' => false),
        'module' => array('text' => lang('App.Module'), 'class' => 'text-center fit px-2'),
        'object' => array('text' => lang('App.Object'), 'class' => 'text-center', 'visible' => false),
        'ip' => array('text' => lang('App.IP'), 'class' => 'text-center', 'visible' => false),
        'user' => array('text' => lang('App.User'), 'class' => 'text-center', 'visible' => true),
        'avatar' => array('text' => lang('App.User'), 'class' => 'text-center fit px-2', 'visible' => false),
        'alias' => array('text' => lang('App.Alias'), 'class' => 'text-center fit px-2'),
        'user' => array('text' => lang('App.User'), 'class' => 'text-center', 'visible' => false),
        'type' => array('text' => lang('App.Type'), 'class' => 'text-center', 'visible' => false),
        'reference' => array('text' => lang('App.Reference'), 'class' => 'text-center', 'visible' => false),
        'log' => array('text' => lang('App.Log'), 'class' => 'text-left px-2  '),
        'author' => array('text' => lang('App.author'), 'class' => 'text-center', 'visible' => false),
        'date' => array('text' => lang('App.date'), 'class' => 'text-center', 'visible' => false),
        'time' => array('text' => lang('App.time'), 'class' => 'text-center', 'visible' => false),
        'created_at' => array('text' => lang('App.created_at'), 'class' => 'text-center', 'visible' => false),
        'updated_at' => array('text' => lang('App.updated_at'), 'class' => 'text-center', 'visible' => false),
        'deleted_at' => array('text' => lang('App.deleted_at'), 'class' => 'text-center', 'visible' => false),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 100,
    'data-side-pagination' => 'server'
);
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$smarty = service('smarty');
$smarty->set_Mode('bs5x');
$smarty->assign('type', 'table');
$smarty->assign('header', lang('History.stats-list-title'));
$smarty->assign('body', '');
$smarty->assign('table', $table);
$smarty->assign('footer', null);
$smarty->assign('file', __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
