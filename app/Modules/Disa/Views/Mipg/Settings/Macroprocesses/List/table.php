<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Disa\Views\Macroprocesses\List\table.php]
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
    'data-url' => '/disa/mipg/api/macroprocesses/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('text' => lang('App.Create'), 'href' => '/disa/settings/macroprocesses/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'macroprocess' => array('text' => lang('App.Macroprocess'), 'visible' => 'false', 'class' => 'text-center'),
        'name' => array('text' => lang('App.Name'), 'class' => 'text-center'),
        'description' => array('text' => lang('App.Description'), 'class' => 'text-center', 'visible' => 'false'),
        'position' => array('text' => lang('App.Position'), 'class' => 'text-center'),
        'responsible' => array('text' => lang('App.Responsible'), 'class' => 'text-center'),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center'),
    ),
    'data-id-field' => 'macroprocess',
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
$card->assign('header', lang('Disa.macroprocesses-list-title'));
$card->assign('header_back', "/disa/settings/home/" . lpk());
$card->assign('body', '');
$card->assign('table', $table);
$card->assign('footer', null);
$card->assign('file', __FILE__);
echo($card->view('components/cards/index.tpl'));

?>