<?php

$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/settings/", "text" => lang("App.Settings"), "class" => false),
    array("href" => "/settings/countries/list/" . lpk(), "text" => lang("App.Countries"), "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>