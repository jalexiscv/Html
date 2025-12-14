<?php

$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/sie/", "text" => "SIE", "class" => false),
    array("href" => "/sie/students/view/{$oid}", "text" => "Estudiante"),
    array("href" => "/sie/observations/reports/{$oid}", "text" => lang("App.Observations"), "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>