<?php

$mclients = model("App\Modules\Nexus\Models\Nexus_Clients");
$client = $mclients->find($oid);
$name = urldecode($client['name']);
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/

$menu = array(
    array("href" => "#", "text" => "Nexo", "class" => false),
    array("href" => "/nexus/clients/home/" . lpk(), "text" => "Clientes", "class" => false),
    array("href" => "/nexus/clients/edit/{$oid}/" . lpk(), "text" => "{$name}", "class" => "active"),
);

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("menu", $menu);
echo($smarty->view('components/breadcrumb/index.tpl'));

?>