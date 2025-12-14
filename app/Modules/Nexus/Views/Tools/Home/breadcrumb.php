<?php
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/

$menu = array(
    array("href" => "#", "text" => "Nexus", "class" => false),
    array("href" => "/nexus/tools/home/" . lpk(), "text" => lang("App.Tools"), "class" => "active"),
);

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("menu", $menu);
echo($smarty->view('components/breadcrumb/index.tpl'));


?>