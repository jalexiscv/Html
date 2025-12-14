<?php

$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/plex/", "text" => "Plex", "class" => false),
    array("href" => "/plex/modules/list/" . lpk(), "text" => lang("App.Modules"), "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>