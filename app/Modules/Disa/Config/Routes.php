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

$mmodules = model("App\Modules\Disa\Models\Disa_Modules");
$mclientsxmodules = model("App\Modules\Disa\Models\Disa_Clients_Modules");
$client = $authentication->get_Client();
$module = $mmodules->get_ModuleByAlias('c4isr');
$cxm = $mclientsxmodules->get_CachedAuthorizedClientByModule($client, $module);

if ($cxm != "authorized") {

    $routes->group('disa',
        ['namespace' => 'App\Modules\Disa\Controllers'],
        function ($subroutes) {
            $subroutes->add('', 'Disa::index');
            $subroutes->add('index', 'Disa::index');
            $subroutes->add('home/(:any)', 'Disa::home/$1');
            /* Historial */
            $subroutes->add('history/home/(:any)', 'History::home/$1');
            $subroutes->add('history/api/logs/(:any)/(:any)/(:any)', 'Api::history/$1/$2/$3');
            /** Etc * */
            $subroutes->add('mipg', 'Mipg::index');
            $subroutes->add('mipg/home/(:any)', 'Mipg::home/$1');
            $subroutes->add('mipg/enter/(:any)', 'Mipg::enter/$1');
            $subroutes->add('mipg/control/(:any)', 'Mipg::control/$1');
            /* Institutional */
            $subroutes->add('institutional/home/(:any)', 'Institutional::home/$1');
            $subroutes->add('institutional/plans/(:any)/(:any)', 'Institutional::plans/$1/$2');
            /** Institutionality **/
            $subroutes->add('mipg/institutionality/delete/(:any)/', 'Institutionality::delete/$1');
            $subroutes->add('mipg/institutionality/home/(:any)/', 'Institutionality::home/$1');
            $subroutes->add('mipg/furag', 'Institutionality::furag');
            $subroutes->add('mipg/furag/(:any)', 'Institutionality::furag/$1');
            $subroutes->add('mipg/furag/(:any)/(:any)/', 'Institutionality::furag/$1/$2');
            /* Committees */
            $subroutes->add('institutionality/committees/(:any)/(:any)/', 'Institutionality::committees/$1/$2');
            /** Settings * */
            $subroutes->add('settings/home/(:any)', 'Settings::home/$1');
            $subroutes->add('settings/characterization/create/', 'Settings::create');
            $subroutes->add('settings/ajax/(:any)/', 'Settings::ajax/$1');
            $subroutes->add('settings/characterization/(:any)/(:any)/', 'Settings::characterization/$1/$2');
            $subroutes->add('settings/macroprocesses/(:any)/(:any)/', 'Settings::macroprocesses/$1/$2');
            $subroutes->add('settings/processes/(:any)/(:any)/', 'Settings::processes/$1/$2');
            $subroutes->add('settings/subprocesses/(:any)/(:any)/', 'Settings::subprocesses/$1/$2');
            $subroutes->add('settings/positions/(:any)/(:any)/', 'Settings::positions/$1/$2');
            $subroutes->add('settings/help/(:any)', 'Settings::help/$1');
            $subroutes->add('settings/(:any)', 'Settings::index/$1');
            /** Processes * */
            $subroutes->add('mipg/processes', 'Processes::index');
            $subroutes->add('mipg/processes/list/', 'Processes::index');
            $subroutes->add('mipg/processes/create/', 'Processes::create');
            $subroutes->add('mipg/processes/view/(:any)/', 'Processes::view/$1');
            $subroutes->add('mipg/processes/edit/(:any)/', 'Processes::edit/$1');
            $subroutes->add('mipg/processes/delete/(:any)/', 'Processes::delete/$1');
            $subroutes->add('mipg/processes/ajax/(:any)/', 'Processes::ajax/$1');
            /** Subprocesses * */
            $subroutes->add('mipg/subprocesses', 'Subprocesses::index');
            $subroutes->add('mipg/subprocesses/list/', 'Subprocesses::index');
            $subroutes->add('mipg/subprocesses/create/', 'Subprocesses::create');
            $subroutes->add('mipg/subprocesses/view/(:any)/', 'Subprocesses::view/$1');
            $subroutes->add('mipg/subprocesses/edit/(:any)/', 'Subprocesses::edit/$1');
            $subroutes->add('mipg/subprocesses/delete/(:any)/', 'Subprocesses::delete/$1');
            $subroutes->add('mipg/subprocesses/ajax/(:any)/', 'Subprocesses::ajax/$1');
            /** Positions * */
            $subroutes->add('mipg/positions', 'Positions::index');
            $subroutes->add('mipg/positions/list/', 'Positions::index');
            $subroutes->add('mipg/positions/create/', 'Positions::create');
            $subroutes->add('mipg/positions/view/(:any)/', 'Positions::view/$1');
            $subroutes->add('mipg/positions/edit/(:any)/', 'Positions::edit/$1');
            $subroutes->add('mipg/positions/delete/(:any)/', 'Positions::delete/$1');
            $subroutes->add('mipg/positions/ajax/(:any)/', 'Positions::ajax/$1');
            /** Dimension * */
            $subroutes->add('mipg/dimensions', 'Dimensions::index');
            $subroutes->add('mipg/dimensions/home/(:any)', 'Dimensions::home/$1');
            $subroutes->add('mipg/dimensions/list/(:any)', 'Dimensions::list/$1');
            $subroutes->add('mipg/dimensions/create/(:any)', 'Dimensions::create/$1');
            $subroutes->add('mipg/dimensions/view/(:any)/', 'Dimensions::view/$1');
            $subroutes->add('mipg/dimensions/edit/(:any)/', 'Dimensions::edit/$1');
            $subroutes->add('mipg/dimensions/delete/(:any)/', 'Dimensions::delete/$1');
            $subroutes->add('mipg/api/dimensions/(:any)/(:any)/(:any)', 'Api::Dimensions/$1/$2/$3');
            /** Politics * */
            $subroutes->add('mipg/politics/list/(:any)', 'Politics::list/$1');
            $subroutes->add('mipg/politics/view/(:any)', 'Politics::view/$1');
            $subroutes->add('mipg/politics/create/(:any)', 'Politics::create/$1');
            $subroutes->add('mipg/politics/edit/(:any)/', 'Politics::edit/$1');
            $subroutes->add('mipg/politics/delete/(:any)/', 'Politics::delete/$1');
            /** Diagnostics * */
            $subroutes->add('mipg/diagnostics', 'Diagnostics::index');
            $subroutes->add('mipg/diagnostics/home/(:any)', 'Diagnostics::home/$1');
            $subroutes->add('mipg/diagnostics/list/(:any)', 'Diagnostics::list/$1');
            $subroutes->add('mipg/diagnostics/create/(:any)', 'Diagnostics::create/$1');
            $subroutes->add('mipg/diagnostics/view/(:any)/', 'Diagnostics::view/$1');
            $subroutes->add('mipg/diagnostics/edit/(:any)/', 'Diagnostics::edit/$1');
            $subroutes->add('mipg/diagnostics/delete/(:any)/', 'Diagnostics::delete/$1');
            /** Components * */
            $subroutes->add('mipg/components', 'Components::index');
            $subroutes->add('mipg/components/home/(:any)', 'Components::home/$1');
            $subroutes->add('mipg/components/list/(:any)', 'Components::list/$1');
            $subroutes->add('mipg/components/create/(:any)', 'Components::create/$1');
            $subroutes->add('mipg/components/view/(:any)/', 'Components::view/$1');
            $subroutes->add('mipg/components/edit/(:any)/', 'Components::edit/$1');
            $subroutes->add('mipg/components/delete/(:any)/', 'Components::delete/$1');
            $subroutes->add('mipg/api/roles/(:any)/(:any)/(:any)', 'Api::Components/$1/$2/$3');
            /** Categories * */
            $subroutes->add('mipg/categories', 'Categories::index');
            $subroutes->add('mipg/categories/home/(:any)', 'Categories::home/$1');
            $subroutes->add('mipg/categories/list/(:any)', 'Categories::list/$1');
            $subroutes->add('mipg/categories/create/(:any)', 'Categories::create/$1');
            $subroutes->add('mipg/categories/view/(:any)/', 'Categories::view/$1');
            $subroutes->add('mipg/categories/edit/(:any)/', 'Categories::edit/$1');
            $subroutes->add('mipg/categories/delete/(:any)/', 'Categories::delete/$1');
            /** Activities * */
            $subroutes->add('mipg/activities', 'Activities::index');
            $subroutes->add('mipg/activities/home/(:any)', 'Activities::home/$1');
            $subroutes->add('mipg/activities/list/(:any)', 'Activities::list/$1');
            $subroutes->add('mipg/activities/create/(:any)', 'Activities::create/$1');
            $subroutes->add('mipg/activities/view/(:any)/', 'Activities::view/$1');
            $subroutes->add('mipg/activities/edit/(:any)/', 'Activities::edit/$1');
            $subroutes->add('mipg/activities/delete/(:any)/', 'Activities::delete/$1');
            /** Scores * */
            $subroutes->add('mipg/scores', 'Scores::index');
            $subroutes->add('mipg/scores/home/(:any)', 'Scores::home/$1');
            $subroutes->add('mipg/scores/list/(:any)', 'Scores::list/$1');
            $subroutes->add('mipg/scores/create/(:any)', 'Scores::create/$1');
            $subroutes->add('mipg/scores/view/(:any)/', 'Scores::view/$1');
            $subroutes->add('mipg/scores/edit/(:any)/', 'Scores::edit/$1');
            $subroutes->add('mipg/scores/delete/(:any)/', 'Scores::delete/$1');
            $subroutes->add('mipg/scores/attachments/(:any)/(:any)/', 'Scores::attachment/$1/$2');
            //$subroutes->add('mipg/api/roles/(:any)/(:any)/(:any)', 'Api::Scores/$1/$2/$3');
            /** Plan * */
            $subroutes->add('mipg/plans/list/(:any)', 'Plans::list/$1');
            $subroutes->add('mipg/plans/create/(:any)', 'Plans::create/$1');
            $subroutes->add('mipg/plans/view/(:any)', 'Plans::view/$1');
            $subroutes->add('mipg/plans/delete/(:any)', 'Plans::delete/$1');
            $subroutes->add('mipg/plans/edit/(:any)/', 'Plans::edit/$1');
            $subroutes->add('mipg/plans/details/(:any)', 'Plans::details/$1');
            $subroutes->add('mipg/plans/team/(:any)', 'Plans::team/$1');
            $subroutes->add('mipg/plans/causes/(:any)/(:any)', 'Plans::causes/$1/$2');
            $subroutes->add('mipg/plans/formulation/(:any)', 'Plans::formulation/$1');
            $subroutes->add('mipg/plans/status/(:any)', 'Plans::status/$1');
            /* Whys */
            $subroutes->add('mipg/plans/whys', 'Whys::index');
            $subroutes->add('mipg/plans/whys/home/(:any)', 'Whys::home/$1');
            $subroutes->add('mipg/plans/whys/list/(:any)', 'Whys::list/$1');
            $subroutes->add('mipg/plans/whys/create/(:any)', 'Whys::create/$1');
            $subroutes->add('mipg/plans/whys/view/(:any)', 'Whys::view/$1');
            $subroutes->add('mipg/plans/whys/edit/(:any)', 'Whys::edit/$1');
            $subroutes->add('mipg/plans/whys/delete/(:any)', 'Whys::delete/$1');
            /* Formularion */
            $subroutes->add('mipg/plans/formulation/(:any)/(:any)', 'Plans::formulation/$1/$2');
            /* Actions */
            $subroutes->add('mipg/plans/actions', 'Actions::index');
            $subroutes->add('mipg/plans/actions/home/(:any)', 'Actions::home/$1');
            $subroutes->add('mipg/plans/actions/list/(:any)', 'Actions::list/$1');
            $subroutes->add('mipg/plans/actions/create/(:any)', 'Actions::create/$1');
            $subroutes->add('mipg/plans/actions/view/(:any)/', 'Actions::view/$1');
            $subroutes->add('mipg/plans/actions/edit/(:any)/', 'Actions::edit/$1');
            $subroutes->add('mipg/plans/actions/delete/(:any)/', 'Actions::delete/$1');
            $subroutes->add('mipg/plans/actions/status/(:any)/', 'Actions::status/$1');
            /* Status */
            $subroutes->add('mipg/plans/statuses', 'Statuses::index');
            $subroutes->add('mipg/plans/statuses/home/(:any)', 'Statuses::home/$1');
            $subroutes->add('mipg/plans/statuses/list/(:any)', 'Statuses::list/$1');
            $subroutes->add('mipg/plans/statuses/create/(:any)', 'Statuses::create/$1');
            $subroutes->add('mipg/plans/statuses/view/(:any)/', 'Statuses::view/$1');
            $subroutes->add('mipg/plans/statuses/edit/(:any)/', 'Statuses::edit/$1');
            $subroutes->add('mipg/plans/statuses/delete/(:any)/', 'Statuses::delete/$1');
            $subroutes->add('mipg/plans/statuses/approval/(:any)/', 'Statuses::approval/$1');
            $subroutes->add('mipg/plans/statuses/approve/(:any)/', 'Statuses::approve/$1');
            $subroutes->add('mipg/plans/statuses/evaluate/(:any)/', 'Statuses::evaluate/$1');
            $subroutes->add('mipg/plans/statuses/evaluation/(:any)/', 'Statuses::evaluation/$1');
            /** Plans * */
            //$subroutes->add('mipg/plans', 'Plans::index');
            //$subroutes->add('mipg/plans/home/(:any)', 'Plans::home/$1');
            //
            //
            //$subroutes->add('mipg/plans/view/(:any)/', 'Plans::view/$1');
            //
            //$subroutes->add('mipg/plans/delete/(:any)/', 'Plans::delete/$1');
            //$subroutes->add('mipg/plans/approve/(:any)', 'Plans::approve/$1');
            //$subroutes->add('mipg/plans/approval/(:any)', 'Plans::approval/$1');
            //$subroutes->add('mipg/plans/evaluate/(:any)', 'Plans::evaluate/$1');
            //$subroutes->add('mipg/plans/evaluation/(:any)', 'Plans::evaluation/$1');
            //$subroutes->add('mipg/plans/manager/causes/(:any)', 'Plans::causes/$1');
            //$subroutes->add('mipg/plans/manager/actions/(:any)', 'Plans::actions/$1');
            /** Plans Institutionals * */
            $subroutes->add('mipg/plans/institutionals', 'Institutionals::index');
            $subroutes->add('mipg/plans/institutionals/list', 'Institutionals::list');
            $subroutes->add('mipg/plans/institutionals/list/ajax/(:any)', 'Institutionals::ajax/$1');
            $subroutes->add('mipg/plans/institutionals/view/(:any)', 'Institutionals::view/$1');
            $subroutes->add('mipg/plans/institutionals/create', 'Institutionals::create');
            $subroutes->add('mipg/plans/institutionals/edit/(:any)', 'Institutionals::edit/$1');
            $subroutes->add('mipg/plans/institutionals/delete/(:any)', 'Institutionals::delete/$1');
            /** Causes Scores* */
            $subroutes->add('mipg/causes/scores/(:any)/(:any)', 'Causes::scores/$1/$2');
            /** Whys * */
            $subroutes->add('mipg/whys/view/(:any)', 'Whys::view/$1');
            $subroutes->add('mipg/whys/create/(:any)', 'Whys::create/$1');
            $subroutes->add('mipg/whys/edit/(:any)', 'Whys::edit/$1');
            $subroutes->add('mipg/whys/delete/(:any)', 'Whys::delete/$1');
            $subroutes->add('mipg/whys/ajax/(:any)/(:any)', 'Whys::ajax/$1/$2');
            /** Reports * */
            $subroutes->add('mipg/reports/home', 'Reports::index');
            /** Board **/
            $subroutes->add('mipg/board', 'Reports::board');
            /** Search * */
            $subroutes->add('search', 'Search::index');
            $subroutes->add('search/(:any)', 'Search::index/$1');
            /** reports * */
            $subroutes->add('mipg/reports', 'Reports::index');
            /** Recommendations **/
            $subroutes->add('mipg/recommendations', 'Recommendations::index');
            $subroutes->add('mipg/recommendations/home/(:any)', 'Recommendations::home/$1');
            $subroutes->add('mipg/recommendations/list/(:any)/(:any)', 'Recommendations::list/$1/$2');
            $subroutes->add('mipg/recommendations/create/(:any)', 'Recommendations::create/$1');
            $subroutes->add('mipg/recommendations/view/(:any)/', 'Recommendations::view/$1');
            $subroutes->add('mipg/recommendations/edit/(:any)/', 'Recommendations::edit/$1');
            $subroutes->add('mipg/recommendations/assign/(:any)/', 'Recommendations::assign/$1');
            $subroutes->add('mipg/recommendations/unassign/(:any)/', 'Recommendations::unassign/$1');
            $subroutes->add('mipg/recommendations/delete/(:any)/', 'Recommendations::delete/$1');
            $subroutes->add('mipg/api/roles/(:any)/(:any)/(:any)', 'Api::Recommendations/$1/$2/$3');
            /** Programs **/
            $subroutes->add('programs', 'Programs::index');
            $subroutes->add('programs/home/(:any)', 'Programs::home/$1');
            $subroutes->add('programs/list/(:any)', 'Programs::list/$1');
            $subroutes->add('programs/create/(:any)', 'Programs::create/$1');
            $subroutes->add('programs/view/(:any)/', 'Programs::view/$1');
            $subroutes->add('programs/edit/(:any)/', 'Programs::edit/$1');
            $subroutes->add('programs/delete/(:any)/', 'Programs::delete/$1');
            /* Api */
            $subroutes->add('api/sigep/(:any)/(:any)', 'Api::sigep/$1/$2');
            $subroutes->add('mipg/api/politics/(:any)/(:any)/(:any)', 'Api::politics/$1/$2/$3');
            $subroutes->add('mipg/api/diagnostics/(:any)/(:any)/(:any)', 'Api::diagnostics/$1/$2/$3');
            $subroutes->add('mipg/api/components/(:any)/(:any)/(:any)', 'Api::components/$1/$2/$3');
            $subroutes->add('mipg/api/categories/(:any)/(:any)/(:any)', 'Api::categories/$1/$2/$3');
            $subroutes->add('mipg/api/activities/(:any)/(:any)/(:any)', 'Api::activities/$1/$2/$3');
            $subroutes->add('mipg/api/recommendations/(:any)/(:any)/(:any)', 'Api::recommendations/$1/$2/$3');
            $subroutes->add('mipg/api/assigned/(:any)/(:any)/(:any)', 'Api::assigned/$1/$2/$3');
            $subroutes->add('mipg/api/unassigned/(:any)/(:any)/(:any)', 'Api::unassigned/$1/$2/$3');
            $subroutes->add('mipg/api/macroprocesses/(:any)/(:any)/(:any)', 'Api::macroprocesses/$1/$2/$3');
            $subroutes->add('mipg/api/processes/(:any)/(:any)/(:any)', 'Api::processes/$1/$2/$3');
            $subroutes->add('mipg/api/subprocesses/(:any)/(:any)/(:any)', 'Api::subprocesses/$1/$2/$3');
            $subroutes->add('mipg/api/positions/(:any)/(:any)/(:any)', 'Api::positions/$1/$2/$3');
            $subroutes->add('mipg/api/scores/(:any)/(:any)/(:any)', 'Api::scores/$1/$2/$3');
            $subroutes->add('institutional/api/plans/(:any)/(:any)/(:any)', 'Api::institucionalplans/$1/$2/$3');
            $subroutes->add('api/programs/(:any)/(:any)/(:any)', 'Api::Programs/$1/$2/$3');

        }
    );
} else {
    $routes->group('disa',
        ['namespace' => 'App\Modules\Disa\Controllers'],
        function ($subroutes) {
            $subroutes->add('(:any)', 'Disa::denied');
        }
    );
}
?>