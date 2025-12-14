<?php

/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/

$menu = array(
    array("href" => "#", "text" => "Disa", "class" => false),
    array("href" => "/disa/settings/home/" . lpk(), "text" => lang("App.Settings"), "class" => false, "levels" => array(
        array("href" => "/disa/settings/characterization/view/" . lpk(), "text" => "Caracterización", "class" => false),
        array("href" => "/disa/settings/macroprocesses/list/" . lpk(), "text" => "Macroprocesos", "class" => false),
        array("href" => "/disa/settings/processes/list/" . lpk(), "text" => "Procesos", "class" => false),
        array("href" => "/disa/settings/subprocesses/list/" . lpk(), "text" => "Subprocesos", "class" => false),
        array("href" => "/disa/settings/positions/list/" . lpk(), "text" => "Cargos", "class" => false, "active" => true),
    )),
    array("href" => "#", "text" => lang("App.Positions"), "class" => "active"),
);

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("menu", $menu);
echo($smarty->view('components/breadcrumb/index.tpl'));

?>
