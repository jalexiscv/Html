<?php
$authentication = service('authentication');
$bootstrap = service('bootstrap');
$server = service('server');
$request = service('request');
//[build]---------------------------------------------------------------------------------------------------------------
$mcustomers = model('App\Modules\Cadastre\Models\Cadastre_Customers');
$mgeoreferences = model('App\Modules\Cadastre\Models\Cadastre_Georeferences');

$route = $request->getVar('route');
$debug = $request->getVar('debug');

$route = $route ?? '1';

if (!empty($debug)) {
    $rows = $mcustomers->get_ListWithGeoreference2(10000, 0, $route);
} else {
    $rows = $mcustomers->get_ListWithGeoreference2(10000, 0, $route);
}
//print_r($rows);
//exit();
$map = view('App\Modules\Cadastre\Views\Maps\Routes\map', array('customers' => $rows, 'route' => $route));
$table = view('App\Modules\Cadastre\Views\Maps\Routes\table', array('customers' => $rows, 'route' => $route));
echo($map);
echo($table);
?>