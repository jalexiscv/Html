<?php

$strings=service("strings");

$mplans = model('App\Modules\Plans\Models\Plans_Plans');
$mactions = model('App\Modules\Plans\Models\Plans_Actions');


$action=$mactions->get_Action($oid);
$plan = $mplans->getPlan($action["plan"]);

$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$menu = array(
    array("href" => "/plans/", "text" => "Planes", "class" => false),
    array("href" => "/plans/plans/list/".lpk(), "text" => "Listado", "class" => false),
    array("href" => "/plans/plans/view/{$oid}", "text" =>$strings->get_ZeroFill($plan["order"],4), "class" => false),
    array("href" => "/plans/actions/{$oid}", "text" => "Acciones", "class" => true)
);
echo($bootstrap->get_Breadcrumb($menu));
?>