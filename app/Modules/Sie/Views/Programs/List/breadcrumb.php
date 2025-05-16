<?php


$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/sie/", "text" => "SIE", "class" => false),
    array("href" => "/sie/programs/home/" . lpk(), "text" => lang("App.Programs"), "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>