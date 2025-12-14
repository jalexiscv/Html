<?php

use Config\Services;

// [services] ----------------------------------------------------------------------------------------------------------
$platform = service('platform');

// [vars] --------------------------------------------------------------------------------------------------------------
if ($platform->get_CandidateModule(__FILE__)) {
    $routes = $routes ?? Services::routes(true);
    $module = 'plex';
    $namespace = 'App\Modules\Plex\Controllers';
    $authorized = $platform->get_AuthorizedModule($module);
    $routes->group($module, ['namespace' => $namespace], function ($subroutes) use ($authorized) {
        if ($authorized === 'authorized') {
            $subroutes->add('', 'Plex::index');
            $subroutes->add('home', 'Plex::index');
            $subroutes->add('home/(:any)', 'Plex::home/$1');
            $subroutes->add('(:any)/(:any)/(:any)', 'Router::route/$1/$2/$3');
        } else {
            $subroutes->add('/', 'Plex::denied');
            $subroutes->add('(:any)', 'Plex::denied');
        }
    });
}
?>