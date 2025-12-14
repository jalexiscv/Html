<?php

use Config\Services;
// [services] ----------------------------------------------------------------------------------------------------------
$platform = service('platform');
// [vars] --------------------------------------------------------------------------------------------------------------
if ($platform->get_CandidateModule(__FILE__)) {
    $routes = $routes ?? Services::routes(true);
    $module = 'internationalization';
    $namespace = 'App\Modules\Internationalization\Controllers';
    $authorized = $platform->get_AuthorizedModule($module);

    $routes->group($module, ['namespace' => $namespace], function ($subroutes) use ($authorized) {
        if ($authorized === 'authorized') {
            $subroutes->add('/', 'Internationalization::index');
            $subroutes->add('/home', 'Internationalization::index');
            $subroutes->add('home/(:any)', 'Internationalization::home/$1');
            $subroutes->add('(:any)/(:any)/(:any)', 'Router::route/$1/$2/$3');
        } else {
            $subroutes->add('/', 'Internationalization::denied');
            $subroutes->add('(:any)', 'Internationalization::denied');
        }
    });
}
?>