<?php


/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/

$menu = array(
    array("href" => "#", "text" => "Disa", "class" => false),
    array("href" => "/disa/settings/home/" . lpk(), "text" => "MiPG", "class" => "active"),
);

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("menu", $menu);
echo($smarty->view('components/breadcrumb/index.tpl'));

?>