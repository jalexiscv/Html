<?php

$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/iris/", "text" => "IRIS", "class" => false),
    array("href" => "/iris/episodes/list/" . lpk(), "text" => "Episodios clínicos", "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>