<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
$table = array(
    'id' => 'table-' . lpk(),
    'data-url' => '/disa/mipg/api/unassigned/json/list/' . $oid,
    'buttons' => array(//'create' => array('text' => lang('App.Create'), 'href' => '/disa/mipg/recommendations/create/' . $oid, 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'recommendation' => array('text' => lang('App.Recommendation'), 'class' => 'text-center', 'visible' => false),
        'reference' => array('text' => lang('App.Reference'), 'class' => 'text-center', 'visible' => false),
        'total' => array('text' => lang('App.Priority'), 'class' => 'text-center'),
        'dimension' => array('text' => lang('App.Dimension'), 'class' => 'text-center', 'visible' => false),
        'politic' => array('text' => lang('App.Politic'), 'class' => 'text-center', 'visible' => false),
        'description' => array('text' => lang('App.Description'), 'class' => 'text-start'),
        //'component' => array('text' => lang('App.Component'), 'class' => 'text-center'),
        //'category' => array('text' => lang('App.Category'), 'class' => 'text-center'),
        //'activity' => array('text' => lang('App.Activity'), 'class' => 'text-center'),
        //'author' => array('text' => lang('App.Author'), 'class' => 'text-center'),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center nowrap'),
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
$smarty->assign('header', sprintf(lang('Disa.recommendations-priority-list-title'), $oid));
$smarty->assign('body', '');
$smarty->assign('table', $table);
$smarty->assign('footer', null);
$smarty->assign('file', __FILE__);
echo($smarty->view('components/tables/index.tpl'));

?>