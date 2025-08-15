<?php

$b = service("bootstrap");
$menu = array(
    array("href" => "/sie/", "text" => "Sie", "class" => false),
    array("href" => "/sie/reports/home/" . lpk(), "text" => "Reportes", "class" => false),
    array("href" => "/sie/reports/humanresources/home?t=" . lpk(), "text" => "Recursos Humanos", "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>