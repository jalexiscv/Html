<?php

$b = service("bootstrap");
$menu = array(
    array("href" => "/sie/", "text" => "SIE", "class" => false),
    array("href" => "/sie/reports/home/" . lpk(), "text" => lang("App.Reports"), "class" => "active"),
    array("href" => "/sie/reports/courses/home?t=" . lpk(), "text" => lang("App.Courses"), "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>
