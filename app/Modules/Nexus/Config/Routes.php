<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
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
$mmodules = model("App\Modules\Nexus\Models\Nexus_Modules");
$mclientsxmodules = model("App\Modules\Nexus\Models\Nexus_Clients_Modules");
$client = $authentication->get_Client();
$module = $mmodules->get_ModuleByAlias('Nexus');
$cxm = $mclientsxmodules->get_AuthorizedClientByModule($client, $module);

if ($cxm == "authorized") {
    $routes->group('nexus',
        ['namespace' => 'App\Modules\Nexus\Controllers'],
        function ($subroutes) {
            $subroutes->add('', 'Nexus::index');
            $subroutes->add('index', 'Nexus::index');
            $subroutes->add('home/(:any)', 'Nexus::home/$1');
            /** Generators * */
            $subroutes->add('generators', 'Generators::index');
            $subroutes->add('generators/home/(:any)', 'Generators::home/$1');
            $subroutes->add('generators/list/(:any)', 'Generators::list/$1');
            $subroutes->add('generators/model/(:any)/', 'Generators::model/$1');
            $subroutes->add('generators/controller/(:any)/', 'Generators::controller/$1');
            $subroutes->add('generators/creator/(:any)/', 'Generators::creator/$1');
            $subroutes->add('generators/viewer/(:any)/', 'Generators::viewer/$1');
            $subroutes->add('generators/editor/(:any)/', 'Generators::editor/$1');
            $subroutes->add('generators/deleter/(:any)/', 'Generators::deleter/$1');
            $subroutes->add('generators/lister/(:any)/', 'Generators::lister/$1');
            $subroutes->add('generators/lang/(:any)/', 'Generators::lang/$1');
            /** Themes **/
            $subroutes->add('themes', 'Themes::index');
            $subroutes->add('themes/home/(:any)', 'Themes::home/$1');
            $subroutes->add('themes/list/(:any)', 'Themes::list/$1');
            $subroutes->add('themes/create/(:any)', 'Themes::create/$1');
            $subroutes->add('themes/view/(:any)/', 'Themes::view/$1');
            $subroutes->add('themes/edit/(:any)/', 'Themes::edit/$1');
            $subroutes->add('themes/delete/(:any)/', 'Themes::delete/$1');
            //$subroutes->add('themes/css/(:any)/index.css', 'Api::css/$1');
            /** Styles **/
            $subroutes->add('styles', 'Styles::index');
            $subroutes->add('styles/home/(:any)', 'Styles::home/$1');
            $subroutes->add('styles/list/(:any)', 'Styles::list/$1');
            $subroutes->add('styles/create/(:any)', 'Styles::create/$1');
            $subroutes->add('styles/view/(:any)/', 'Styles::view/$1');
            $subroutes->add('styles/edit/(:any)/', 'Styles::edit/$1');
            $subroutes->add('styles/delete/(:any)/', 'Styles::delete/$1');
            $subroutes->add('styles/importer/(:any)', 'Styles::importer/$1');
            $subroutes->add('api/styles/(:any)/(:any)/(:any)', 'Api::Styles/$1/$2/$3');
            //$subroutes->add('generators/ajax/(:any)/', 'Generators::ajax/$1');
            /** Minifiers * */
            $subroutes->add('minifiers/php/(:any)', 'Minifiers::php/$1');
            /** Modules * */
            $subroutes->add('modules', 'Modules::index');
            $subroutes->add('modules/home/(:any)', 'Modules::home/$1');
            $subroutes->add('modules/list/(:any)', 'Modules::list/$1');
            $subroutes->add('modules/create/(:any)', 'Modules::create/$1');
            $subroutes->add('modules/view/(:any)/', 'Modules::view/$1');
            $subroutes->add('modules/edit/(:any)/', 'Modules::edit/$1');
            $subroutes->add('modules/delete/(:any)/', 'Modules::delete/$1');
            /*Tools*/
            $subroutes->add('tools/home/(:any)', 'Tools::home/$1');
            $subroutes->add('tools/modules/(:any)/(:any)', 'Tools::modules/$1/$2/');
            $subroutes->add('tools/texttophp/(:any)/(:any)', 'Tools::texttophp/$1/$2/');
            /** Api **/
            $subroutes->add('api/clients/(:any)/(:any)/(:any)', 'Api::clients/$1/$2/$3');
            $subroutes->add('api/generators/(:any)/(:any)/(:any)', 'Api::generators/$1/$2/$3');
            $subroutes->add('api/themes/(:any)/(:any)/(:any)', 'Api::Themes/$1/$2/$3');
            $subroutes->add('api/modules/(:any)/(:any)/(:any)', 'Api::Modules/$1/$2/$3');
            $subroutes->add('api/authorizations/(:any)/(:any)/(:any)', 'Api::Authorizations/$1/$2/$3');
            $subroutes->add('api/oauths/(:any)/(:any)/(:any)', 'Api::Oauths/$1/$2/$3');
            //$subroutes->add('ajax/regions/(:any)/', 'Ajax::regions/$1');
            //$subroutes->add('ajax/cities/(:any)/', 'Ajax::cities/$1');
            /** Router **/
            $subroutes->add('(:any)/(:any)/(:any)', 'Router::route/$1/$2/$3');
        }
    );
} else {
    $routes->group('Nexus',
        ['namespace' => 'App\Modules\Nexus\Controllers'],
        function ($subroutes) {
            $subroutes->add('(:any)', 'Nexus::denied');
        }
    );
}
?>