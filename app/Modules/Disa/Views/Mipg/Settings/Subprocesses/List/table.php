<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Subprocesses\List\table.php]
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
    'data-url' => '/disa/mipg/api/subprocesses/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('text' => lang('App.Create'), 'href' => '/disa/settings/subprocesses/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        //'subprocess' => array('text' => lang('App.Subprocess'), 'class' => 'text-center'),
        'process' => array('text' => lang('App.Process'), 'class' => 'text-center'),
        'name' => array('text' => lang('App.Name'), 'class' => 'text-center'),
        //'description' => array('text' => lang('App.Description'), 'class' => 'text-center'),
        'position' => array('text' => lang('App.Position'), 'class' => 'text-center'),
        'responsible' => array('text' => lang('App.Responsible'), 'class' => 'text-center'),
        //'phone' => array('text' => lang('App.Phone'), 'class' => 'text-center'),
        //'email' => array('text' => lang('App.email'), 'class' => 'text-center'),
        //'author' => array('text' => lang('App.author'), 'class' => 'text-center'),
        //'created_at' => array('text' => lang('App.created_at'), 'class' => 'text-center'),
        //'updated_at' => array('text' => lang('App.updated_at'), 'class' => 'text-center'),
        //'deleted_at' => array('text' => lang('App.deleted_at'), 'class' => 'text-center'),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center'),
    ),
    'data-page-size' => 10,
    'data-side-pagination' => 'server'
);
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$card = service('smarty');
$card->set_Mode('bs5x');
$card->assign('type', 'table');
$card->assign('header', lang('Disa.subprocesses-list-title'));
$card->assign('header_back', "/disa/settings/home/" . lpk());
$card->assign('body', '');
$card->assign('table', $table);
$card->assign('footer', null);
$card->assign('file', __FILE__);
echo($card->view('components/cards/index.tpl'));
/** Logger **/
history_logger(array(
    "log" => pk(),
    "module" => "DISA",
    "author" => $authentication->get_User(),
    "description" => "El usuario <b>@" . $authentication->get_Alias() . "</b> accedio al listado general de subprocesos.",
    "code" => "",
));
?>
