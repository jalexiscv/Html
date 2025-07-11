<?php

$b = service("bootstrap");
$menu = array(
    array("href" => "/sie/", "text" => "Sie", "class" => false),
    array("href" => "/sie/reports/home/" . lpk(), "text" => lang("App.Reports"), "class" => false),
    array("href" => "/sie/reports/control/home?t=" . lpk(), "text" => "Registro y Control", "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>
