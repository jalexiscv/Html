<?php

/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/

$menu = array(
    array("href" => "#", "text" => "Disa", "class" => false),
    array("href" => "/disa/mipg/recommendations/home/" . lpk(), "text" => lang("App.Recommendations"), "class" => "active"),
);

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("menu", $menu);
echo($smarty->view('components/breadcrumb/index.tpl'));

?>