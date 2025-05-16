<?php

$mcountries = model('App\Modules\Settings\Models\Settings_Countries');
$mregions = model('App\Modules\Settings\Models\Settings_Regions');

$country = $mcountries->getCountry($oid);

$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/settings/", "text" => lang("App.Settings"), "class" => false),
    array("href" => "/settings/countries/list/" . lpk(), "text" => lang("App.Countries"), "class" => false),
    array("href" => "/settings/countries/view/" . @$country["country"], "text" => @$country["name"], "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>