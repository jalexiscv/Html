<?php

$b = service("bootstrap");
$menu = array(
    array("href" => "/firewall/", "text" => "Firewall", "class" => false),
    array("href" => "/firewall/whitelist/list/" . lpk(), "text" => lang("Firewall.Whitelist"), "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>