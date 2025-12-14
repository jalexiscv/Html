<?php
$bootstrap = service('bootstrap');
$data = $parent->get_Array();

$fprofile = view('App\Modules\Sie\Views\Teachers\Edit\Tabs\profile', $data);
$fphotos = view('App\Modules\Sie\Views\Teachers\Edit\Tabs\photos', $data);
$fmoodle = view('App\Modules\Sie\Views\Teachers\Edit\Tabs\moodle', $data);

$tabs = array(
    array("id" => "profile", "text" => "Perfil", "content" => $fprofile, "active" => true),
    //array("id" => "photos", "text" => "QL", "content" => $fphotos, "active" => false),
    array("id" => "moodle", "text" => "Moodle", "content" => $fmoodle, "active" => false),
);
$tabs = new \App\Libraries\Html\Bootstrap\Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" => sprintf(lang("Users.edit-title"), $oid),
    "content" => $tabs,
    "header-back" => "/sie/teachers/list/" . lpk(),
));
echo($card);

?>