<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Cadastre\Views\Resources\List\table.php]
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
    'data-url' => '/cadastre/api/resources/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('text' => ICON_ADD . lang('App.Create'), 'href' => '/cadastre/resources/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'resource' => array('text' => lang('App.Resource'), 'class' => 'text-center', 'visible' => false),
        'title' => array('text' => lang('App.Title'), 'class' => 'text-center', 'visible' => false),
        'cover' => array('text' => "#", 'class' => 'text-center'),
        'description' => array('text' => lang('App.Description'), 'class' => 'text-start'),
        'authors' => array('text' => lang('App.Authors'), 'class' => 'text-center', 'visible' => false),
        'use' => array('text' => lang('App.Use'), 'class' => 'text-center', 'visible' => false),
        'category' => array('text' => lang('App.Category'), 'class' => 'text-center', 'visible' => false),
        'level' => array('text' => lang('App.Level'), 'class' => 'text-center', 'visible' => false),
        'objective' => array('text' => lang('App.objective'), 'class' => 'text-center', 'visible' => false),
        'program' => array('text' => lang('App.program'), 'class' => 'text-center', 'visible' => false),
        'type' => array('text' => lang('App.type'), 'class' => 'text-center', 'visible' => false),
        'format' => array('text' => lang('App.format'), 'class' => 'text-center', 'visible' => false),
        'language' => array('text' => lang('App.language'), 'class' => 'text-center', 'visible' => false),
        'file' => array('text' => lang('App.file'), 'class' => 'text-center', 'visible' => false),
        'url' => array('text' => lang('App.url'), 'class' => 'text-center', 'visible' => false),
        'keywords' => array('text' => lang('App.keywords'), 'class' => 'text-center', 'visible' => false),
        'author' => array('text' => lang('App.author'), 'class' => 'text-center', 'visible' => false),
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
$smarty->assign('header', lang('Resources.list-title'));
$smarty->assign("header_back", "/cadastre/");
$smarty->assign('body', '');
$smarty->assign('table', $table);
$smarty->assign('footer', null);
$smarty->assign('file', __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
