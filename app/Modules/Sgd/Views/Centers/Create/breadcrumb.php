<?php

$b = service("bootstrap");
$menu = array(
    array("href" => "/sgd/", "text" => "SGD", "class" => false),
    array("href" => "/sgd/centers/list/" . lpk(), "text" => "Centros de gestión", "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>