<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\C4isr\Views\Mails\List\table.php]
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
    'data-url' => '/c4isr/api/mails/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('text' => lang('App.Create'), 'href' => '/c4isr/mails/create/' . lpk(), 'class' => 'btn-secondary'),
        'import' => array('text' => lang('App.Import'), 'href' => '/c4isr/mails/import/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'mail' => array('text' => lang('App.Mail'), 'class' => 'text-center'),
        'profile' => array('text' => lang('App.Profile'), 'class' => 'text-center'),
        'email' => array('text' => lang('App.Email'), 'class' => 'text-center'),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 10,
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
$smarty->assign('header', lang('Mails.list-title'));
$smarty->assign('header_back', lang('Mails.list-title'));
$smarty->assign('body', '');
$smarty->assign('table', $table);
$smarty->assign('footer', null);
$smarty->assign('file', __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
