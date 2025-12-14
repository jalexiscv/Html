<?php
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/

$options = array(
    array("href" => "/nexus/tools/modules/generator/" . lpk(), "title" => "Generador de módulos", "icon" => "fas fa-tasks"),
    array("href" => "/nexus/tools/texttophp/generator/" . lpk(), "title" => "Texto a PHP", "icon" => "fas fa-tasks"),

);

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("header", lang("App.Tools"));
$smarty->assign("header_back", "/social/home/" . lpk());
$smarty->assign("options", $options);
echo($smarty->view('components/panels/settings.tpl'));


?>