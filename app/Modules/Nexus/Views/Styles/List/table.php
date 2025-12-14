<?php
/*
* -----------------------------------------------------------------------------
*  ╔═╗╔╗╔╔═╗╔═╗╦╔╗ ╦  ╔═╗
*  ╠═╣║║║╚═╗╚═╗║╠╩╗║  ║╣  [FRAMEWORK][App\Modules\Application\Views\Styles\List\table.php]
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
    'data-url' => '/nexus/api/styles/json/list/' . $oid,
    'buttons' => array(
        'create' => array('text' => lang('App.Create'), 'href' => '/nexus/styles/create/' . $oid, 'class' => 'btn-secondary'),
        'importer' => array('text' => lang('App.Importer'), 'href' => '/nexus/styles/importer/' . $oid, 'class' => 'btn-warning'),
    ),
    'cols' => array(
        'style' => array('text' => lang('App.Style'), 'class' => 'text-center'),
        'theme' => array('text' => lang('App.Theme'), 'class' => 'text-center', "visible" => false),
        'selectors' => array('text' => lang('App.Selectors'), 'class' => 'text-start'),
        'default' => array('text' => lang('App.STD'), 'class' => 'text-center'),
        'xxl' => array('text' => lang('App.XXL'), 'class' => 'text-center'),
        'xl' => array('text' => lang('App.XL'), 'class' => 'text-center'),
        'lg' => array('text' => lang('App.LG'), 'class' => 'text-center'),
        'md' => array('text' => lang('App.MD'), 'class' => 'text-center'),
        'sm' => array('text' => lang('App.SM'), 'class' => 'text-center'),
        'xs' => array('text' => lang('App.XS'), 'class' => 'text-center'),
        //'date' => array('text' => lang('App.date'), 'class' => 'text-center'),
        //'time' => array('text' => lang('App.time'), 'class' => 'text-center'),
        //'author' => array('text' => lang('App.author'), 'class' => 'text-center'),
        //'importer' => array('text' => lang('App.importer'), 'class' => 'text-center'),
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
$smarty = service('smarty');
$smarty->set_Mode('bs5x');
$smarty->assign('type', 'table');
$smarty->assign('header', lang('Nexus.styles-list-title'));
$smarty->assign('header_back', "/nexus/themes/list/" . lpk());
$smarty->assign('body', '');
$smarty->assign('table', $table);
$smarty->assign('footer', null);
$smarty->assign('file', __FILE__);
echo($smarty->view('components/cards/index.tpl'));
?>
