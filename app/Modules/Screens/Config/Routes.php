<?php

use Config\Services;


$twoLevelsUpDir = dirname(dirname(__FILE__));
$dirName = basename($twoLevelsUpDir);
if (strpos($dirName, '_') === false) {
    $authentication = service("authentication");
    $routes = !isset($routes) ? Services::routes(true) : $routes;
    $mdm = model("App\Models\Application_Modules");
    $mdcxm = model("App\Models\Application_Clients_Modules");
    $module = 'screens';
    $namespace = "App\Modules\Screens\Controllers";
    $cxm = $mdcxm->get_CachedAuthorizedClientByModule($authentication->get_Client(), $mdm->get_Module($module, true));

    if ($cxm == "authorized") {
        $routes->group($module,
            ['namespace' => $namespace],
            function ($subroutes) {
                $subroutes->add('/', 'Screens::index');
                $subroutes->add('/home', 'Screens::index');
                $subroutes->add('home/(:any)', 'Screens::home/$1');
                $subroutes->add('(:any)/(:any)/(:any)', 'Router::route/$1/$2/$3');
            }
        );
    } else {
        $routes->group($module,
            ['namespace' => $namespace],
            function ($subroutes) {
                $subroutes->add('/', 'Screens::denied');
                $subroutes->add('(:any)', 'Screens::denied');
            }
        );
    }
}
?>