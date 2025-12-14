<?php
//registered Se recibe y representa la matricula del cliente
$bootstrap = service('bootstrap');
$mcg = model("App\Modules\Cadastre\Models\Cadastre_Georeferences");
$r = $mcg->get_ByRegistration($registered);
//print_r($r);
if (!isset($r['registration'])) {
    $r = array();
    $r["georeference"] = "No tiene";
    $r['latitude_decimal'] = 0;
    $r['longitude_decimal'] = 0;
}

$map = new App\Libraries\Maps();
$map->set_LatAndLngFields($field_longitude, $field_latitude);
$map->add_Marker($r["latitude_decimal"], $r["longitude_decimal"], array(
    'title' => 'Eiffel Tower',
    'defColor' => '#FA6D6D',
    'defSymbol' => 'C',
    'infoCloseOthers' => true
));
$map->set_Center($r["latitude_decimal"], $r["longitude_decimal"]);
$map->set_Zoom(18);

//[Build]-----------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Georeferencia {$r["georeference"] }",
    //"header-back" => $back,
    "content" => $map,
));
echo($card);


?>