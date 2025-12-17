<?php

use Config\Services;


$twoLevelsUpDir = dirname(dirname(__FILE__));
$dirName = basename($twoLevelsUpDir);
if (strpos($dirName, '_') === false) {
    $authentication = service("authentication");
    $routes = !isset($routes) ? Services::routes(true) : $routes;
    $mdm = model("App\Models\Application_Modules");
    $mdcxm = model("App\Models\Application_Clients_Modules");
    $module = 'Facebook';
    $namespace = "App\Modules\Facebook\Controllers";
    $cxm = $mdcxm->get_CachedAuthorizedClientByModule($authentication->get_Client(), $mdm->get_Module($module, true));

    if ($cxm == "authorized") {
        $routes->group($module,
            ['namespace' => $namespace],
            function ($subroutes) {
                $subroutes->add('/', 'Facebook::index');
                $subroutes->add('/home', 'Facebook::index');
                $subroutes->add('home/(:any)', 'Facebook::home/$1');
                $subroutes->add('(:any)/(:any)/(:any)', 'Router::route/$1/$2/$3');
                $subroutes->add('signin', 'Facebook::signin');
                $subroutes->add('authentication', 'Authentication::index');
                $subroutes->add('authentication/logout', 'Authentication::logout');
                $subroutes->add('authentication/fblogout', 'Authentication::fblogout');
            }
        );
    } else {
        $routes->group($module,
            ['namespace' => $namespace],
            function ($subroutes) {
                $subroutes->add('/', 'Facebook::denied');
                $subroutes->add('(:any)', 'Facebook::denied');
            }
        );
    }
}

?>