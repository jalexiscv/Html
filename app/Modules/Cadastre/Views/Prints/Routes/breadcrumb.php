<?php
$menu = array(
    array("href" => "/cadastre/", "text" => "Catastro", "class" => false),
);
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("menu", $menu);
echo($smarty->view("components/breadcrumb/index.tpl"));
?>