<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Plex') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "plex-denied" => "{$views}\Denied\index",
    "plex-home" => "{$views}\Home\index",
    //[Clients]----------------------------------------------------------------------------------------
    "plex-clients-home" => "$views\Clients\Home\index",
    "plex-clients-list" => "$views\Clients\List\index",
    "plex-clients-view" => "$views\Clients\View\index",
    "plex-clients-create" => "$views\Clients\Create\index",
    "plex-clients-edit" => "$views\Clients\Edit\index",
    "plex-clients-delete" => "$views\Clients\Delete\index",
    //[Modules]----------------------------------------------------------------------------------------
    "plex-modules-home"=>"$views\Modules\Home\index",
    "plex-modules-list"=>"$views\Modules\List\index",
    "plex-modules-view"=>"$views\Modules\View\index",
    "plex-modules-create"=>"$views\Modules\Create\index",
    "plex-modules-edit"=>"$views\Modules\Edit\index",
    "plex-modules-delete"=>"$views\Modules\Delete\index",
    //[others]------------------------------------------------------------------------------------------
);
$uri = !isset($rviews[$prefix]) ? $rviews["default"] : $rviews[$prefix];
$json = view($uri, $data);
$mmu = model("App\Modules\Messenger\Models\Messenger_Users");
//[build]---------------------------------------------------------------------------------------------------------------
$assign = array();
$assign['theme'] = "Higgs";
$assign['main_template'] = safe_json($json, 'main_template', 'c8c4');
$assign['breadcrumb'] = safe_json($json, 'breadcrumb');
$assign['main'] = safe_json($json, 'main');
$assign['left'] = get_plex_sidebar();
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