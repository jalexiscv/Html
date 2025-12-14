<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$data = $parent->get_Array();
$data['version'] = round(($server->get_DirectorySize(APPPATH . 'Modules/Security') / 102400), 4);
$rviews = array(
    "default" => "$views\E404\index",
    "cadastre-denied" => "$views\Denied\index",
    "cadastre-home" => "$views\Home\index",
    "cadastre-tools-home" => "$views\Tools\Home\index",
    "cadastre-tools-texttophp-generator" => "$views\Tools\Texttophp\Generator\index",
    "cadastre-generators-list" => "$views\Generators\List\index",
    /** customers **/
    "cadastre-customers-home" => "$views\Customers\Home\index",
    "cadastre-customers-list" => "$views\Customers\List\index",
    "cadastre-customers-view" => "$views\Customers\View\index",
    "cadastre-customers-create" => "$views\Customers\Create\index",
    "cadastre-customers-edit" => "$views\Customers\Edit\index",
    "cadastre-customers-delete" => "$views\Customers\Delete\index",
    "cadastre-customers-geo" => "$views\Customers\Geo\index",
    /** Resources **/
    "cadastre-resources-home" => "$views\Resources\Home\index",
    "cadastre-resources-list" => "$views\Resources\List\index",
    "cadastre-resources-view" => "$views\Resources\View\index",
    "cadastre-resources-create" => "$views\Resources\Create\index",
    "cadastre-resources-edit" => "$views\Resources\Edit\index",
    "cadastre-resources-delete" => "$views\Resources\Delete\index",
    /** Networks **/
    "cadastre-networks-home" => "$views\Networks\Home\index",
    "cadastre-networks-list" => "$views\Networks\List\index",
    "cadastre-networks-view" => "$views\Networks\View\index",
    "cadastre-networks-create" => "$views\Networks\Create\index",
    "cadastre-networks-edit" => "$views\Networks\Edit\index",
    "cadastre-networks-delete" => "$views\Networks\Delete\index",
    /** Maps **/
    "cadastre-maps-home" => "$views\Maps\Home\index",
    "cadastre-maps-routes" => "$views\Maps\Routes\index",
    /** Prints **/
    "cadastre-prints-route" => "$views\Prints\Route\index",
    "cadastre-prints-routes" => "$views\Prints\Routes\index",
    /** Sense **/
    "cadastre-sense-home" => "$views\Sense\Home\index",
    "cadastre-sense-create" => "$views\Sense\Create\index",
    /** tools  **/
    "cadastre-tools-anomalies-list" => "$views\Tools\Anomalies\List\index",
    "cadastre-tools-georeferences-updater" => "$views\Tools\Georeferences\Updater\index",
);
$uri = !isset($rviews[$prefix]) ? $rviews["default"] : $rviews[$prefix];
$json = view($uri, $data);
$mmu = model("App\Modules\Messenger\Models\Messenger_Users");
//[build]---------------------------------------------------------------------------------------------------------------
$assign = array();
$assign['theme'] = "Higgs";
$assign['main_template'] = safe_json($json, 'main_template', "c8c4");
$assign['breadcrumb'] = safe_json($json, 'breadcrumb');
$assign['main'] = safe_json($json, 'main');
$assign['left'] = get_cadastre_sidebar();
$assign['right'] = safe_json($json, 'right') . get_application_copyright();
$assign['logo_portrait'] = get_logo("logo_portrait");
$assign['logo_landscape'] = get_logo('logo_landscape');
$assign['logo_portrait_light'] = get_logo("logo_portrait_light");
$assign['logo_landscape_light'] = get_logo("logo_landscape_light");
$assign['type'] = safe_json($json, 'type');
$assign['canonical'] = safe_json($json, 'canonical');
$assign['title'] = safe_json($json, 'title');
$assign['description'] = safe_json($json, 'description');
$assign['categories'] = safe_json($json, 'categories');
$assign['featureds'] = safe_json($json, 'featureds');
$assign['sponsoreds'] = safe_json($json, 'sponsoreds');
$assign['articles'] = safe_json($json, 'articles');
$assign['themostseens'] = safe_json($json, 'themostseens');
$assign['article'] = safe_json($json, 'article');
$assign['next'] = safe_json($json, 'next');
$assign['previus'] = safe_json($json, 'previus');
$assign['messenger'] = true;
$assign['messenger_users'] = $mmu->get_OnlineUsers(100, 0);
$benchmark->stop('time');
$assign['benchmark'] = $benchmark->getElapsedTime('time', 4);
$assign['version'] = $data['version'];
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Higgs\index", $assign);
echo($template);
?>