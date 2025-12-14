<?php

use App\Libraries\Html\Bootstrap\Tabs;

$bootstrap = service('bootstrap');
$data = $parent->get_Array();
$fprofile = view('App\Modules\Plex\Clients\Edit\Tabs\profile', $data);
$fdatabase = view('App\Modules\Plex\Clients\Edit\Tabs\database', $data);
$fmodules = view('App\Modules\Plex\Clients\Edit\Tabs\modules', $data);
$fgoogle = view('App\Modules\Plex\Clients\Edit\Tabs\google', $data);
$ffacebook = view('App\Modules\Plex\Clients\Edit\Tabs\facebook', $data);
$flogos = view('App\Modules\Plex\Clients\Edit\Tabs\logos', $data);
$ftheme = view('App\Modules\Plex\Clients\Edit\Tabs\theme', $data);

$tabs = array(
    array("id" => "profile", "text" => "Perfil", "content" => $fprofile, "active" => true),
    array("id" => "database", "icon" => ICON_DB, "content" => $fdatabase, "active" => false),
    array("id" => "modules", "icon" => ICON_MODULES, "content" => $fmodules, "active" => false),
    array("id" => "google", "icon" => ICON_GOOGLE, "content" => $fgoogle, "active" => false),
    array("id" => "facebook", "icon" => ICON_FACEBOOK, "content" => $ffacebook, "active" => false),
    array("id" => "logos", "icon" => ICON_LOGOS, "content" => $flogos, "active" => false),
    array("id" => "theme", "icon" => ICON_THEME, "content" => $ftheme, "active" => false),
);
$tabs = new Tabs($tabs);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" => sprintf("Cliente: %s", $oid),
    "content" => $tabs,
    "header-back" => "/plex/clients/list/" . lpk(),
));
echo($card);
?>