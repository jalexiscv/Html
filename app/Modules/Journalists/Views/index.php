<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Journalists') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "journalists-denied" => "{$views}\Denied\index",
    "journalists-home" => "{$views}\Home\index",
    //[Journalists]-----------------------------------------------------------------------------------------------------
    "journalists-journalists-home" => "$views\Journalists\Home\index",
    "journalists-journalists-list" => "$views\Journalists\List\index",
    "journalists-journalists-view" => "$views\Journalists\View\index",
    "journalists-journalists-check" => "$views\Journalists\Check\index",
    "journalists-journalists-create" => "$views\Journalists\Create\index",
    "journalists-journalists-edit" => "$views\Journalists\Edit\index",
    "journalists-journalists-delete" => "$views\Journalists\Delete\index",
    "journalists-journalists-prints" => "$views\Prints\index",
    "journalists-journalists-qrs" => "$views\Qrs\index",
    //[Medias]----------------------------------------------------------------------------------------------------------
    "journalists-medias-home" => "$views\Medias\Home\index",
    "journalists-medias-list" => "$views\Medias\List\index",
    "journalists-medias-view" => "$views\Medias\View\index",
    "journalists-medias-create" => "$views\Medias\Create\index",
    "journalists-medias-edit" => "$views\Medias\Edit\index",
    "journalists-medias-delete" => "$views\Medias\Delete\index",
    //[Invitations]----------------------------------------------------------------------------------------
    "journalists-invitations-home"=>"$views\Invitations\Home\index",
    "journalists-invitations-list"=>"$views\Invitations\List\index",
    "journalists-invitations-view"=>"$views\Invitations\View\index",
    "journalists-invitations-check"=>"$views\Invitations\Check\index",
    "journalists-invitations-create"=>"$views\Invitations\Create\index",
    "journalists-invitations-edit"=>"$views\Invitations\Edit\index",
    "journalists-invitations-delete"=>"$views\Invitations\Delete\index",
    //[others]----------------------------------------------------------------------------------------------------------
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
$assign['left'] = get_journalists_sidebar();
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