<?php
$bootstrap = service('bootstrap');
$data = $parent->get_Array();
$fprofile = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\profile', $data);
$fsnies = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\snies', $data);
$ffiles = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\files', $data);
$finterview = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\interview', $data);
$fdiscounts = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\discounts', $data);
$tabs = array(
    array("id" => "profile", "text" => "Perfil", "content" => $fprofile, "active" => true),
    array("id" => "snies", "text" => "Snies", "content" => $fsnies, "active" => false),
    array("id" => "interview", "text" => "Entrevista", "content" => $finterview, "active" => false),
    array("id" => "files", "text" => "Archivos", "content" => $ffiles, "active" => false),
    array("id" => "discounts", "text" => "Descuentos", "content" => $fdiscounts, "active" => false),
);
$tabs = new \App\Libraries\Html\Bootstrap\Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => sprintf("Actualizar estudiante: %s", $oid),
    "content" => $tabs,
    "header-back" => "/sie/agreements/list/" . lpk(),
));
echo($card);

?>