<?php

use Config\Services;

$authentication = service("authentication");

if (!isset($routes)) {
    $routes = Services::routes(true);
}

$mmodules = model("App\Modules\Wallet\Models\Wallet_Modules");
$mclientsxmodules = model("App\Modules\Wallet\Models\Wallet_Clients_Modules");
$client = $authentication->get_Client();
$module = $mmodules->get_ModuleByAlias('wallet');
$cxm = $mclientsxmodules->get_CachedAuthorizedClientByModule($client, $module);

if ($cxm == "authorized") {

    $routes->group('wallet',
        ['namespace' => 'App\Modules\Wallet\Controllers'],
        function ($subroutes) {
            $subroutes->add('', 'Wallet::index');
            $subroutes->add('index', 'Wallet::index');
            $subroutes->add('home/(:any)', 'Wallet::home/$1');
            /** Currencies * */
            $subroutes->add('currencies/list', 'Currencies::list');
            $subroutes->add('currencies/create', 'Currencies::create');
            $subroutes->add('currencies/view/(:any)', 'Currencies::view/$1');
            $subroutes->add('currencies/edit/(:any)', 'Currencies::edit/$1');
            $subroutes->add('currencies/delete/(:any)', 'Currencies::delete/$1');
            $subroutes->add('currencies/ajax/(:any)', 'Currencies::ajax/$1');
            /** Transactions * */
            $subroutes->add('transactions/list/(:any)', 'Transactions::list/$1');
            $subroutes->add('transactions/create/(:any)', 'Transactions::create/$1');
            $subroutes->add('transactions/view/(:any)', 'Transactions::view/$1');
            $subroutes->add('transactions/edit/(:any)', 'Transactions::edit/$1');
            $subroutes->add('transactions/delete/(:any)', 'Transactions::delete/$1');
            $subroutes->add('transactions/ajax/(:any)', 'Transactions::ajax/$1');
            /** Acounts **/
            $subroutes->add('acounts/ajax/(:any)/(:any)', 'Acounts::ajax/$1/$2');

            $subroutes->add('api/transactions/(:any)/(:any)/(:any)', 'Api::transactions/$1/$2/$3');
        }
    );

} else {
    $routes->group('wallet',
        ['namespace' => 'App\Modules\Wallet\Controllers'],
        function ($subroutes) {
            $subroutes->add('(:any)', 'Wallet::denied');
        }
    );
}

?>