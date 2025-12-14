<?php

$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/sie/", "text" => "SIE", "class" => false),
    array("href" => "/sie/settings/home/" . lpk(), "text" => lang("App.Settings"), "class" => false),
    array("href" => "/sie/institutions/list/" . lpk(), "text" => lang("App.Institutions"), "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>