<?php
$request = service('request');
$mcountries = model("App\Modules\Sie\Models\Sie_Countries");
$mregions = model("App\Modules\Sie\Models\Sie_Regions");
$mcities = model("App\Modules\Sie\Models\Sie_Cities");

$country = $oid;

$regions = $mregions->get_SelectData($country);

if (is_array($regions)) {
    echo(json_encode($regions));
} else {
    echo(json_encode(array()));
}

?>