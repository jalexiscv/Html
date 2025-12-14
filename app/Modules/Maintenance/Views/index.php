<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Maintenance') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "maintenance-denied" => "{$views}\Denied\index",
    "maintenance-home" => "{$views}\Home\index",
    //[Assets]----------------------------------------------------------------------------------------
    "maintenance-assets-home" => "$views\Assets\Home\index",
    "maintenance-assets-list" => "$views\Assets\List\index",
    "maintenance-assets-view" => "$views\Assets\View\index",
    "maintenance-assets-create" => "$views\Assets\Create\index",
    "maintenance-assets-edit" => "$views\Assets\Edit\index",
    "maintenance-assets-delete" => "$views\Assets\Delete\index",
    //[Sheets]----------------------------------------------------------------------------------------
    "maintenance-sheets-home" => "$views\Sheets\Home\index",
    "maintenance-sheets-list" => "$views\Sheets\List\index",
    "maintenance-sheets-view" => "$views\Sheets\View\index",
    "maintenance-sheets-create" => "$views\Sheets\Create\index",
    "maintenance-sheets-edit" => "$views\Sheets\Edit\index",
    "maintenance-sheets-delete" => "$views\Sheets\Delete\index",
    //[Maintenances]----------------------------------------------------------------------------------------
    "maintenance-maintenances-home" => "$views\Maintenances\Home\index",
    "maintenance-maintenances-list" => "$views\Maintenances\List\index",
    "maintenance-maintenances-view" => "$views\Maintenances\View\index",
    "maintenance-maintenances-create" => "$views\Maintenances\Create\index",
    "maintenance-maintenances-edit" => "$views\Maintenances\Edit\index",
    "maintenance-maintenances-delete" => "$views\Maintenances\Delete\index",
    //[Notifications]----------------------------------------------------------------------------------------
    "maintenance-notifications-home" => "$views\Notifications\Home\index",
    "maintenance-notifications-list" => "$views\Notifications\List\index",
    "maintenance-notifications-view" => "$views\Notifications\View\index",
    "maintenance-notifications-create" => "$views\Notifications\Create\index",
    "maintenance-notifications-edit" => "$views\Notifications\Edit\index",
    "maintenance-notifications-delete" => "$views\Notifications\Delete\index",
    //[Types]----------------------------------------------------------------------------------------
    "maintenance-types-home" => "$views\Types\Home\index",
    "maintenance-types-list" => "$views\Types\List\index",
    "maintenance-types-view" => "$views\Types\View\index",
    "maintenance-types-create" => "$views\Types\Create\index",
    "maintenance-types-edit" => "$views\Types\Edit\index",
    "maintenance-types-delete" => "$views\Types\Delete\index",
    //[others]------------------------------------------------------------------------------------------
);
$uri = !isset($rviews[$prefix]) ? $rviews["default"] : $rviews[$prefix];
$json = view($uri, $data);
//[build]---------------------------------------------------------------------------------------------------------------
$assign = array();
$assign['theme'] = "Higgs";
$assign['main_template'] = safe_json($json, 'main_template', 'c9c3');
$assign['breadcrumb'] = safe_json($json, 'breadcrumb');
$assign['main'] = safe_json($json, 'main');
$assign['left'] = get_maintenance_sidebar();
$assign['right'] = safe_json($json, 'right') . get_application_copyright();
$assign['logo_portrait'] = get_logo("logo_portrait");
$assign['logo_landscape'] = get_logo("logo_landscape");
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
$assign['messenger_users'] = false;
$benchmark->stop('time');
$assign['modals'] = safe_module_modal();
$assign['benchmark'] = $benchmark->getElapsedTime('time', 4);
$assign['version'] = $version;
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Gamma\index", $assign);
echo($template);
?>