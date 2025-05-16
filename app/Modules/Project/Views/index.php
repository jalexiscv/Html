<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Project') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "project-denied" => "{$views}\Denied\index",
    "project-home" => "{$views}\Home\index",
    //[Projects]----------------------------------------------------------------------------------------
    "project-projects-home" => "$views\Projects\Home\index",
    "project-projects-list" => "$views\Projects\List\index",
    "project-projects-view" => "$views\Projects\View\index",
    "project-projects-create" => "$views\Projects\Create\index",
    "project-projects-edit" => "$views\Projects\Edit\index",
    "project-projects-delete" => "$views\Projects\Delete\index",
    //[Tasks]----------------------------------------------------------------------------------------
    "project-tasks-home" => "$views\Tasks\Home\index",
    "project-tasks-list" => "$views\Tasks\List\index",
    "project-tasks-view" => "$views\Tasks\View\index",
    "project-tasks-create" => "$views\Tasks\Create\index",
    "project-tasks-edit" => "$views\Tasks\Edit\index",
    "project-tasks-delete" => "$views\Tasks\Delete\index",
    //[Statuses]----------------------------------------------------------------------------------------
    "project-statuses-home" => "$views\Statuses\Home\index",
    "project-statuses-list" => "$views\Statuses\List\index",
    "project-statuses-view" => "$views\Statuses\View\index",
    "project-statuses-create" => "$views\Statuses\Create\index",
    "project-statuses-edit" => "$views\Statuses\Edit\index",
    "project-statuses-delete" => "$views\Statuses\Delete\index",
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
$assign['left'] = get_project_sidebar();
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
