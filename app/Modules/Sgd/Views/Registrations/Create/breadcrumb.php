<?php
$b = service("bootstrap");
$menu = array(
    array("href" => "/sgd/", "text" => "sgd", "class" => false),
    array("href" => "/sgd/registrations/home/" . lpk(), "text" => lang("App.registrations"), "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>