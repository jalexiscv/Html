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
$rows = $mcustomers->get_ListWithGeoreference2(10000, 0, $route);
$format = view('App\Modules\Cadastre\Views\Prints\Routes\format', array('customers' => $rows, 'route' => $route));
echo($format);
?>