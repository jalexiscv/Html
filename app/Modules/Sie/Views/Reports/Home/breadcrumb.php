<?php

$b = service("bootstrap");
$menu = array(
    array("href" => "/sie/", "text" => "Sie", "class" => false),
    array("href" => "/sie/reports/home/" . lpk(), "text" => "Reportes", "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>