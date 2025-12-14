<?php
/*
 * Copyright (c) 2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

$bootstrap = service("bootstrap");
$back = "";

$mcustomers = model("App\Modules\Cadastre\Models\Cadastre_Customers");
$mgeoreferences = model("App\Modules\Cadastre\Models\Cadastre_Georeferences");

$georeferences = $mgeoreferences
    ->select('cadastre_customers.customer, cadastre_customers.registration')
    ->from('cadastre_customers')
    ->join('cadastre_georeferences', 'cadastre_customers.registration = cadastre_georeferences.registration', 'left')
    ->where('cadastre_georeferences.registration', null)
    ->findAll();

echo($mgeoreferences->getLastQuery()->getQuery());
print_r($georeferences);
exit();
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
    $table .= "</tr>";
}
$table .= "</table>";

$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang('Anomalias/Sin Georeferencia'),
    "header-back" => $back,
    "content" => $table,
));
echo($card);
?>