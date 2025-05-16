<?php


$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$menu = array(
    array("href" => "/plans/", "text" => "Planes", "class" => false),
);
echo($bootstrap->get_Breadcrumb($menu));
?>