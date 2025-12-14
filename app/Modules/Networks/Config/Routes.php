<?php

use Config\Services;


$twoLevelsUpDir = dirname(dirname(__FILE__));
$dirName = basename($twoLevelsUpDir);
if (strpos($dirName, '_') === false) {
    $authentication = service("authentication");
    $routes = !isset($routes) ? Services::routes(true) : $routes;
    $mdm = model("App\Models\Application_Modules");
    $mdcxm = model("App\Models\Application_Clients_Modules");
    $module = 'Networks';
    $namespace = "App\Modules\Networks\Controllers";
    $cxm = $mdcxm->get_CachedAuthorizedClientByModule($authentication->get_Client(), $mdm->get_Module($module, true));

    if ($cxm == "authorized") {
        $routes->group($module,
            ['namespace' => $namespace],
            function ($subroutes) {
                $subroutes->add('/', 'Networks::index');
                $subroutes->add('/home', 'Networks::index');
                $subroutes->add('home/(:any)', 'Networks::home/$1');
                $subroutes->add('(:any)/(:any)/(:any)', 'Router::route/$1/$2/$3');
            }
        );
    } else {
        $routes->group($module,
            ['namespace' => $namespace],
            function ($subroutes) {
                $subroutes->add('/', 'Networks::denied');
                $subroutes->add('(:any)', 'Networks::denied');
            }
        );
    }
}
?>