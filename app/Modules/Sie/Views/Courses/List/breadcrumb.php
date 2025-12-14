<?php

$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/sie/", "text" => "SIE", "class" => false),
    array("href" => "/sie/courses/list/" . lpk(), "text" => lang("App.Courses"), "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>