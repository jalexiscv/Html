<?php

$strings=service("strings");

$mplans = model('App\Modules\Plans\Models\Plans_Plans');
$mcauses = model('App\Modules\Plans\Models\Plans_Causes');

$causes = $mcauses->get_Cause($oid);
$plan = $mplans->getPlan($causes["plan"]);

$bootstrap = service("bootstrap");
//[models]--------------------------------------------------------------------------------------------------------------
$menu = array(
    array("href" => "/plans/", "text" => "Planes", "class" => false),
    array("href" => "/plans/plans/list/".lpk(), "text" => "Listado", "class" => false),
    array("href" => "/plans/plans/view/{$plan["plan"]}", "text" =>$strings->get_ZeroFill($plan["order"],4), "class" => false),
    array("href" => "/plans/plans/causes/{$plan["plan"]}", "text" => "Causas", "class" => false),
    array("href" => "/plans/whys/list/{$oid}", "text" => "Porques", "class" => true)
);
echo($bootstrap->get_Breadcrumb($menu));
?>