<?php

use App\Libraries\Html\Bootstrap\Tabs;

$bootstrap = service('bootstrap');
$data = $parent->get_Array();
$fprofile = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\profile', $data);
$fsnies = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\snies', $data);
$ffiles = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\files', $data);
$finterview = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\interview', $data);
$fdiscounts = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\discounts', $data);
$fobservations = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\observations', $data);
$ffinance = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\finance', $data);
$fregionalization = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\regionalization', $data);
$fstatus = view('App\Modules\Sie\Views\Registrations\Edit\Tabs\status', $data);


$tabs = array(
    array("id" => "profile", "text" => "Perfil", "content" => $fprofile, "active" => true),
    array("id" => "regionalization", "icon" => ICON_GEO, "content" => $fregionalization, "active" => false),
    array("id" => "snies", "text" => "Snies", "content" => $fsnies, "active" => false),
    //array("id" => "observations", "text" => "Observaciones", "content" => $fobservations, "active" => false),
    //array("id" => "interview", "text" => "Entrevista", "content" => $finterview, "active" => false),
    array("id" => "files", "text" => "Archivos", "content" => $ffiles, "active" => false),
    //array("id" => "discounts", "text" => "Descuentos", "content" => $fdiscounts, "active" => false),
    //array("id" => "finance", "text" => "Información Financiera", "content" => $ffinance, "active" => false),
    array("id" => "status", "text" => "Estado", "content" => $fstatus, "active" => false),
);
$tabs = new Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => sprintf("Actualizar estudiante: %s", $oid),
    "content" => $tabs,
    "header-back" => "/sie/registrations/list/" . lpk(),
));
echo($card);
?>