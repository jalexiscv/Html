<?php


$bootstrap = service("bootstrap");
//Recibe la actividad $oid
$mrequirements = model('App\Modules\Iso9001\Models\Iso9001_Requirements');
$mdiagnostics = model('App\Modules\Iso9001\Models\Iso9001_Diagnostics');
$mcomponents = model('App\Modules\Iso9001\Models\Iso9001_Components');
$mcategories = model('App\Modules\Iso9001\Models\Iso9001_Categories');
$mactivities = model('App\Modules\Iso9001\Models\Iso9001_Activities');

$activity = $mactivities->where("activity", $oid)->first();
$category = $mcategories->where("category", $activity['category'])->first();
$component = $mcomponents->where("component", $category['component'])->first();
$diagnostic = $mdiagnostics->where("diagnostic", $component['diagnostic'])->first();

$menu = array(
    array("href" => "/iso9001/", "text" => "ISO9001", "class" => false),
    array("href" => "/iso9001/requirements/home/" . lpk(), "text" => lang("App.Requirements"), "class" => false),
    array("href" => "/iso9001/diagnostics/home/{$diagnostic['requirement']}", "text" => lang("App.Diagnostics"), "class" => false),
    array("href" => "/iso9001/components/home/{$component['diagnostic']}", "text" => lang("App.Components"), "class" => false),
    array("href" => "/iso9001/categories/home/{$component['component']}", "text" => lang("App.Categories"), "class" => false),
    array("href" => "/iso9001/activities/home/{$category['category']}", "text" => lang("App.Activities"), "class" => "active")
);
echo($bootstrap->get_Breadcrumb($menu));
?>