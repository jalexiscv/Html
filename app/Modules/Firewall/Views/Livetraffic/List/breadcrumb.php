<?php
$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/firewall/", "text" => lang("App.Firewall"), "class" => false),
    array("href" => "/firewall/livetraffic/list/" . lpk(), "text" => lang("App.Livetraffic"), "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>