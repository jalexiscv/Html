<?php
$bootstrap = service("bootstrap");
$back = "";

$mcustomers = model("App\Modules\Cadastre\Models\Cadastre_Customers");
$mgeoreferences = model("App\Modules\Cadastre\Models\Cadastre_Georeferences");

$georeferences = $mgeoreferences
    ->select('*')
    ->where('updated_at IN (SELECT MAX(updated_at) FROM cadastre_georeferences WHERE((latitude_decimal <3.8) OR (latitude_decimal >3.93)OR(longitude_decimal<-76.35)OR(longitude_decimal>-76.27)) GROUP BY registration)')
    ->findAll();

//echo($mgeoreferences->getLastQuery()->getQuery());
//print_r($georeferences);
//exit();
$table = "<table>";
$table .= "<thead>";
$table .= "<tr>";
$table .= "<th>#</th>";
$table .= "<th>georeference</th>";
$table .= "<th>registration</th>";
$table .= "<th>latitude_decimal</th>";
$table .= "<th>longitude_decimal</th>";
$table .= "</tr>";
$table .= "</thead>";
$table .= "<tbody>";
$count = 0;
foreach ($georeferences as $georeference) {
    $count++;
    $table .= "<tr>";
    $table .= "<td>" . $count . "</td>";
    $table .= "<td>" . $georeference['georeference'] . "</td>";
    $table .= "<td>" . $georeference['registration'] . "</td>";
    $table .= "<td>" . $georeference['latitude_decimal'] . "</td>";
    $table .= "<td>" . $georeference['longitude_decimal'] . "</td>";
    $table .= "</tr>";
}
$table .= "</table>";

$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Anomalias/Latitud o Longitud'),
    "header-back" => $back,
    "content" => $table,
));
echo($card);
?>