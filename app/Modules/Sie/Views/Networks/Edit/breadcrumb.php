<?php

$b = service("bootstrap");
$menu = array(
    array("href" => "/sie/", "text" => "SIE", "class" => false),
    array("href" => "/sie/settings/home/" . lpk(), "text" => lang("App.Settings"), "class" => false),
    array("href" => "/sie/networks/list/" . lpk(), "text" => lang("App.Networks"), "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>