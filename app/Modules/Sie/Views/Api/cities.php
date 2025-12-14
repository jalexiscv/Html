<?php
$request = service('request');
$mcountries = model("App\Modules\Sie\Models\Sie_Countries");
$mregions = model("App\Modules\Sie\Models\Sie_Regions");
$mcities = model("App\Modules\Sie\Models\Sie_Cities");

$region = $oid;

$cities = $mcities->get_SelectData($region);

if (is_array($cities)) {
    echo(json_encode($cities));
} else {
    echo(json_encode(array()));
}

?>