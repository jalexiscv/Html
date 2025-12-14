<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Sogt') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "sogt-denied" => "{$views}\Denied\index",
    "sogt-home" => "{$views}\Home\index",
    //[Devices]---------------------------------------------------------------------------------------------------------
    "sogt-devices-home"=>"$views\Devices\Home\index",
    "sogt-devices-list"=>"$views\Devices\List\index",
    "sogt-devices-view"=>"$views\Devices\View\index",
    "sogt-devices-create"=>"$views\Devices\Create\index",
    "sogt-devices-edit"=>"$views\Devices\Edit\index",
    "sogt-devices-delete"=>"$views\Devices\Delete\index",
    //[Telemetry]-------------------------------------------------------------------------------------------------------
    "sogt-telemetry-home"=>"$views\Telemetry\Home\index",
    "sogt-telemetry-list"=>"$views\Telemetry\List\index",
    "sogt-telemetry-view"=>"$views\Telemetry\View\index",
    "sogt-telemetry-create"=>"$views\Telemetry\Create\index",
    "sogt-telemetry-edit"=>"$views\Telemetry\Edit\index",
    "sogt-telemetry-delete"=>"$views\Telemetry\Delete\index",
    //[maps]------------------------------------------------------------------------------------------------------------
    "sogt-maps-home"=>"$views\Maps\Home\index",
    //[others]----------------------------------------------------------------------------------------------------------
);
$uri = !isset($rviews[$prefix]) ? $rviews["default"] : $rviews[$prefix];
$json = view($uri, $data);
//[build]---------------------------------------------------------------------------------------------------------------
$assign = array();
$assign['theme'] = "Higgs";
$assign['main_template'] = safe_json($json, 'main_template', 'c9c3');
$assign['breadcrumb'] = safe_json($json, 'breadcrumb');
$assign['main'] = safe_json($json, 'main');
$assign['left'] = get_sogt_sidebar();
$assign['right'] = safe_json($json, 'right') . get_application_copyright();
$assign['right-sidebar-header'] = safe_json($json, 'right-sidebar-header');
$assign['right-sidebar-content'] = safe_json($json, 'right-sidebar-content');
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
$assign['messenger_users'] = "";
$benchmark->stop('time');
$assign['benchmark'] = $benchmark->getElapsedTime('time', 4);
$assign['version'] = $version;
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Beta\index", $assign);
echo($template);
?>
