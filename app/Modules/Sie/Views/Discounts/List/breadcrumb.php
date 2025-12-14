<?php

$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/sie/", "text" => "Sie", "class" => false),
    array("href" => "/sie/settings/home/" . lpk(), "text" => lang("App.Settings"), "class" => false),
    array("href" => "/sie/discounts/home/" . lpk(), "text" => lang("App.Discounts"), "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>