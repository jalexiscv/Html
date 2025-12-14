<?php
/*
 * Copyright (c) 2021-2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use Config\Services;

$authentication = service("authentication");

if (!isset($routes)) {
    $routes = Services::routes(true);
}

$routes->group('history',
    ['namespace' => 'App\Modules\History\Controllers'],
    function ($subroutes) {
        $subroutes->add('', 'History::index');
        $subroutes->add('index', 'History::index');
        $subroutes->add('home/(:any)', 'History::home/$1');
        $subroutes->add('general/list/(:any)', 'History::general/$1');
        //[Stats]
        $subroutes->add('stats', 'Stats::index');
        $subroutes->add('stats/home/(:any)', 'Stats::home/$1');
        $subroutes->add('stats/list/(:any)', 'Stats::list/$1');
        $subroutes->add('stats/create/(:any)', 'Stats::create/$1');
        $subroutes->add('stats/view/(:any)/', 'Stats::view/$1');
        $subroutes->add('stats/edit/(:any)/', 'Stats::edit/$1');
        $subroutes->add('stats/delete/(:any)/', 'Stats::delete/$1');
        /* Api */
        $subroutes->add('api/general/(:any)/(:any)', 'Api::general/$1/$2');
        $subroutes->add('api/stats/(:any)/(:any)/(:any)', 'Api::Stats/$1/$2/$3');
    }
);
?>