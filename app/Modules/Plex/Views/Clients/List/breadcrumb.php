<?php

$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/plex/", "text" => "Plex", "class" => false),
    array("href" => "/plex/clients/home/" . lpk(), "text" => lang("App.Clients"), "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>