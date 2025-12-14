<?php

//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/security/";
$table = $bootstrap->get_DynamicTable(array(
    'id' => 'table-' . lpk(),
    'data-url' => '/security/api/roles/json/list/' . lpk(),
    'buttons' => array(
        'create' => array('text' => lang('App.Create'), 'href' => '/security/roles/create/' . lpk(), 'class' => 'btn-secondary'),
    ),
    'cols' => array(
        'rol' => array('text' => lang('App.Rol'), 'class' => 'text-center fit px-2'),
        'name' => array('text' => lang('App.Name'), 'class' => 'text-start'),
        //'description' => array('text' => lang('App.Description'), 'class' => 'text-center'),
        //'author' => array('text' => lang('App.Author'), 'class' => 'text-center'),
        //'created_at' => array('text' => lang('App.created_at'), 'class' => 'text-center'),
        //'updated_at' => array('text' => lang('App.updated_at'), 'class' => 'text-center'),
        //'deleted_at' => array('text' => lang('App.deleted_at'), 'class' => 'text-center'),
        'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
    ),
    'data-page-size' => 50,
    'data-side-pagination' => 'server'
));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Roles.list-title'),
    "header-back" => $back,
    "alert" => array(
        'type' => 'info',
        'title' => lang('App.Remember'),
        'message' => lang("Roles.roles-info")
    ),
    "content" => $table,
));
echo($card);
?>