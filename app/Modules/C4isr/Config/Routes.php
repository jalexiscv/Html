<?php

use Config\Services;


$twoLevelsUpDir = dirname(dirname(__FILE__));
$dirName = basename($twoLevelsUpDir);
if (strpos($dirName, '_') === false) {
    $authentication = service("authentication");
    $routes = !isset($routes) ? Services::routes(true) : $routes;
    $mdm = model("App\Models\Application_Modules");
    $mdcxm = model("App\Models\Application_Clients_Modules");
    $module = 'C4isr';
    $namespace = "App\Modules\C4isr\Controllers";
    $cxm = $mdcxm->get_CachedAuthorizedClientByModule($authentication->get_Client(), $mdm->get_Module($module, true));

    if ($cxm == "authorized") {
        $routes->group($module,
            ['namespace' => $namespace],
            function ($subroutes) {
                $subroutes->add('/', 'C4isr::index');
                $subroutes->add('/home', 'C4isr::index');
                $subroutes->add('home/(:any)', 'C4isr::home/$1');
                $subroutes->add('(:any)/(:any)/(:any)', 'Router::route/$1/$2/$3');
            }
        );
    } else {
        $routes->group($module,
            ['namespace' => $namespace],
            function ($subroutes) {
                $subroutes->add('/', 'C4isr::denied');
                $subroutes->add('(:any)', 'C4isr::denied');
            }
        );
    }
}

?>