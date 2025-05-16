<?php

$mcountries = model('App\Modules\Settings\Models\Settings_Countries');
$mregions = model('App\Modules\Settings\Models\Settings_Regions');
$mcities = model('App\Modules\Settings\Models\Settings_Cities');

$region = $mregions->getRegion($oid);
$country = $mcountries->getCountry($region["country"]);

$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/settings/", "text" => lang("App.Settings"), "class" => false),
    array("href" => "/settings/countries/list/" . lpk(), "text" => lang("App.Countries"), "class" => false),
    array("href" => "/settings/countries/view/" . @$region["country"], "text" => @$country["name"], "class" => false),
    array("href" => "/settings/regions/view/" . @$region["region"], "text" => @$region["name"], "class" => false),
);
echo($bootstrap->get_Breadcrumb($menu));
?>