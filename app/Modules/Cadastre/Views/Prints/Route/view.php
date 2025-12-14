<?php
$authentication = service('authentication');
$bootstrap = service('bootstrap');
$server = service('server');
$request = service('request');
//[build]---------------------------------------------------------------------------------------------------------------
$mcustomers = model('App\Modules\Cadastre\Models\Cadastre_Customers');
$mgeoreferences = model('App\Modules\Cadastre\Models\Cadastre_Georeferences');

$rows = $mcustomers->get_ListWithGeoreference2(10000, 0, $oid);

$total = count($rows);
$start = substr($rows[0]['registration'], 13 - 5, 5);
$end = substr($rows[$total - 1]['registration'], 13 - 5, 5);

$info = view('App\Modules\Cadastre\Views\Prints\Route\info', array('customers' => $rows, 'route' => $oid, "total" => $total, "start" => $start, "end" => $end));
$format = view('App\Modules\Cadastre\Views\Prints\Route\format', array('customers' => $rows, 'route' => $oid));
echo($info);
echo($format);
?>