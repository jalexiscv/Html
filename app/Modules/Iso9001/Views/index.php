<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Iso9001') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "iso9001-denied" => "{$views}\Denied\index",
    "iso9001-home" => "{$views}\Home\index",
    //[requirements]--------------------------------------------------------------------------------------------------------
    "iso9001-requirements-home" => "$views\Requirements\Home\index",
    "iso9001-requirements-list" => "$views\Requirements\List\index",
    "iso9001-requirements-view" => "$views\Requirements\View\index",
    "iso9001-requirements-create" => "$views\Requirements\Create\index",
    "iso9001-requirements-edit" => "$views\Requirements\Edit\index",
    "iso9001-requirements-delete" => "$views\Requirements\Delete\index",
    //[Diagnostics]-----------------------------------------------------------------------------------------------------
    "iso9001-diagnostics-home" => "$views\Diagnostics\Home\index",
    "iso9001-diagnostics-list" => "$views\Diagnostics\List\index",
    "iso9001-diagnostics-view" => "$views\Diagnostics\View\index",
    "iso9001-diagnostics-create" => "$views\Diagnostics\Create\index",
    "iso9001-diagnostics-edit" => "$views\Diagnostics\Edit\index",
    "iso9001-diagnostics-delete" => "$views\Diagnostics\Delete\index",
    //[Components]------------------------------------------------------------------------------------------------------
    "iso9001-components-home" => "$views\Components\Home\index",
    "iso9001-components-list" => "$views\Components\List\index",
    "iso9001-components-view" => "$views\Components\View\index",
    "iso9001-components-create" => "$views\Components\Create\index",
    "iso9001-components-edit" => "$views\Components\Edit\index",
    "iso9001-components-delete" => "$views\Components\Delete\index",
    //[Categories]------------------------------------------------------------------------------------------------------
    "iso9001-categories-home" => "$views\Categories\Home\index",
    "iso9001-categories-list" => "$views\Categories\List\index",
    "iso9001-categories-view" => "$views\Categories\View\index",
    "iso9001-categories-create" => "$views\Categories\Create\index",
    "iso9001-categories-edit" => "$views\Categories\Edit\index",
    "iso9001-categories-delete" => "$views\Categories\Delete\index",
    //[Activities]------------------------------------------------------------------------------------------------------
    "iso9001-activities-home" => "$views\Activities\Home\index",
    "iso9001-activities-list" => "$views\Activities\List\index",
    "iso9001-activities-view" => "$views\Activities\View\index",
    "iso9001-activities-create" => "$views\Activities\Create\index",
    "iso9001-activities-edit" => "$views\Activities\Edit\index",
    "iso9001-activities-delete" => "$views\Activities\Delete\index",
    //[Scores]------------------------------------------------------------------------------------------------------
    "iso9001-scores-home" => "$views\Scores\Home\index",
    "iso9001-scores-list" => "$views\Scores\List\index",
    "iso9001-scores-view" => "$views\Scores\View\index",
    "iso9001-scores-create" => "$views\Scores\Create\index",
    "iso9001-scores-edit" => "$views\Scores\Edit\index",
    "iso9001-scores-delete" => "$views\Scores\Delete\index",
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
$assign['left'] = get_iso9001_sidebar();
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
