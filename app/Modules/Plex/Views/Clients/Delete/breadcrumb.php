<?php

$b = service("bootstrap");
$menu = array(
    array("href" => "/plex/", "text" => "Plex", "class" => false),
    array("href" => "/plex/clients/home/" . lpk(), "text" => lang("App.Clients"), "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>