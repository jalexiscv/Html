<?php

$table = array(
    'id' => 'table-' . lpk(),
    'data-url' => '/c4isr/api/incidents/json/list/' . $oid . '?t=' . lpk(),
    'buttons' => array(//'create' => array('text' => lang('App.Create'), 'href' => '/c4isr/incidents/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'incident' => array('text' => lang('App.Incident'), 'class' => 'text-center'),
        'case' => array('text' => lang('App.Case'), 'class' => 'text-center', 'visible' => false),
        'mail' => array('text' => lang('App.Mail'), 'class' => 'text-center', 'visible' => false),
        'alias' => array('text' => lang('App.Alias'), 'class' => 'text-center', 'visible' => false),
        'reference' => array('text' => lang('App.Reference'), 'class' => 'text-center'),
        'author' => array('text' => lang('App.author'), 'class' => 'text-center', 'visible' => false),
        'created_at' => array('text' => lang('App.created_at'), 'class' => 'text-center'),
        'updated_at' => array('text' => lang('App.updated_at'), 'class' => 'text-center', 'visible' => false),
        'deleted_at' => array('text' => lang('App.deleted_at'), 'class' => 'text-center', 'visible' => false),
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
$smtable = service('smarty');
$smtable->set_Mode('bs5x');
$smtable->caching = 0;
$smtable->assign('type', 'table');
$smtable->assign('header', lang('Incidents.list-title'));
$smtable->assign('body', '');
$smtable->assign('table', $table);
$smtable->assign('footer', null);
$smtable->assign('file', __FILE__);
echo($smtable->view('components/cards/index.tpl'));
?>