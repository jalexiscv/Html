<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use Config\Services;


$twoLevelsUpDir = dirname(dirname(__FILE__));
$dirName = basename($twoLevelsUpDir);
if (strpos($dirName, '_') === false) {
    $authentication = service("authentication");
    $routes = !isset($routes) ? Services::routes(true) : $routes;
    $mdm = model("App\Models\Application_Modules");
    $mdcxm = model("App\Models\Application_Clients_Modules");
    $module = 'Web';
    $namespace = "App\Modules\Web\Controllers";
    $cxm = $mdcxm->get_CachedAuthorizedClientByModule($authentication->get_Client(), $mdm->get_Module($module, true));

    if ($cxm == "authorized") {
        $routes->group($module,
            ['namespace' => $namespace],
            function ($subroutes) {
                $subroutes->add('/', 'Web::index');
                $subroutes->add('/home', 'Web::index');
                $subroutes->add('home/(:any)', 'Web::home/$1');
                $subroutes->add('(:any)/(:any)/(:any)', 'Router::route/$1/$2/$3');
            }
        );
    } else {
        $routes->group($module,
            ['namespace' => $namespace],
            function ($subroutes) {
                $subroutes->add('/', 'Web::denied');
                $subroutes->add('(:any)', 'Web::denied');
            }
        );
    }
}
?>