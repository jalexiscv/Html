<?php

$b = service("bootstrap");
$menu = array(
    array("href" => "/maintenance/", "text" => "Mantenimientos", "class" => false),
    array("href" => "/maintenance/maintenances/list/" . lpk(), "text" => "Mantenimientos", "class" => "active"),
);
echo($b->get_Breadcrumb($menu));

?>