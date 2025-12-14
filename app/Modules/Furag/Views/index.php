<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Furag') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "furag-denied" => "{$views}\Denied\index",
    "furag-home" => "{$views}\Home\index",
    //[Dimensions]----------------------------------------------------------------------------------------
    "furag-dimensions-home" => "$views\Dimensions\Home\index",
    "furag-dimensions-list" => "$views\Dimensions\List\index",
    "furag-dimensions-view" => "$views\Dimensions\View\index",
    "furag-dimensions-create" => "$views\Dimensions\Create\index",
    "furag-dimensions-edit" => "$views\Dimensions\Edit\index",
    "furag-dimensions-delete" => "$views\Dimensions\Delete\index",
    //[Politics]----------------------------------------------------------------------------------------
    "furag-politics-home" => "$views\Politics\Home\index",
    "furag-politics-list" => "$views\Politics\List\index",
    "furag-politics-view" => "$views\Politics\View\index",
    "furag-politics-create" => "$views\Politics\Create\index",
    "furag-politics-edit" => "$views\Politics\Edit\index",
    "furag-politics-delete" => "$views\Politics\Delete\index",
    //[Questions]----------------------------------------------------------------------------------------
    "furag-questions-home" => "$views\Questions\Home\index",
    "furag-questions-list" => "$views\Questions\List\index",
    "furag-questions-view" => "$views\Questions\View\index",
    "furag-questions-create" => "$views\Questions\Create\index",
    "furag-questions-edit" => "$views\Questions\Edit\index",
    "furag-questions-delete" => "$views\Questions\Delete\index",
    //[others]------------------------------------------------------------------------------------------
);
$uri = !isset($rviews[$prefix]) ? $rviews["default"] : $rviews[$prefix];
$json = view($uri, $data);
//[build]---------------------------------------------------------------------------------------------------------------
$assign = array();
$assign['theme'] = "Higgs";
$assign['main_template'] = safe_json($json, 'main_template', 'c8c4');
$assign['breadcrumb'] = safe_json($json, 'breadcrumb');
$assign['main'] = safe_json($json, 'main');
$assign['left'] = get_furag_sidebar();
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
$assign['messenger_users'] = "";
$benchmark->stop('time');
$assign['benchmark'] = $benchmark->getElapsedTime('time', 4);
$assign['version'] = $version;
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Higgs\index", $assign);
echo($template);
?>