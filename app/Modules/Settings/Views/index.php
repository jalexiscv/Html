<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Settings') / 102400), 6);
$data = $parent->get_Array();
//[views]---------------------------------------------------------------------------------------------------------------
$rviews = array(
    "default" => "{$views}\E404\index",
    "settings-denied" => "{$views}\Denied\index",
    "settings-home" => "{$views}\Home\index",
    //[Logos]-----------------------------------------------------------------------------------------------------------
    "settings-logos-home" => "{$views}\Logos\Home\index",
    "settings-logos-list" => "{$views}\Logos\List\index",
    "settings-logos-view" => "{$views}\Logos\View\index",
    "settings-logos-create" => "{$views}\Logos\Create\index",
    "settings-logos-edit" => "{$views}\Logos\Edit\index",
    "settings-logos-delete" => "{$views}\Logos\Delete\index",
    //[emails]----------------------------------------------------------------------------------------------------------
    "settings-emails-home" => "{$views}\Emails\Home\index",
    "settings-emails-smtp" => "{$views}\Emails\Smtp\index",
    "settings-emails-imap" => "{$views}\Emails\Imap\index",
    "settings-emails-test" => "{$views}\Emails\Test\index",
    //[Countries]----------------------------------------------------------------------------------------
    "settings-countries-home" => "$views\Countries\Home\index",
    "settings-countries-list" => "$views\Countries\List\index",
    "settings-countries-view" => "$views\Countries\View\index",
    "settings-countries-create" => "$views\Countries\Create\index",
    "settings-countries-edit" => "$views\Countries\Edit\index",
    "settings-countries-delete" => "$views\Countries\Delete\index",
    //[Regions]----------------------------------------------------------------------------------------
    "settings-regions-home" => "$views\Regions\Home\index",
    "settings-regions-list" => "$views\Regions\List\index",
    "settings-regions-view" => "$views\Regions\View\index",
    "settings-regions-create" => "$views\Regions\Create\index",
    "settings-regions-edit" => "$views\Regions\Edit\index",
    "settings-regions-delete" => "$views\Regions\Delete\index",
    //[Cities]----------------------------------------------------------------------------------------
    "settings-cities-home"=>"$views\Cities\Home\index",
    "settings-cities-list"=>"$views\Cities\List\index",
    "settings-cities-view"=>"$views\Cities\View\index",
    "settings-cities-create"=>"$views\Cities\Create\index",
    "settings-cities-edit"=>"$views\Cities\Edit\index",
    "settings-cities-delete"=>"$views\Cities\Delete\index",
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
$assign['left'] = get_settings_sidebar();
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
$assign['benchmark'] = $benchmark->getElapsedTime('time', 4);
$assign['version'] = $version;
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Higgs\index", $assign);
echo($template);
?>