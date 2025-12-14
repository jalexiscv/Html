<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Organization') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "organization-denied" => "{$views}\Denied\index",
    "organization-home" => "{$views}\Home\index",
    //[Plans]-----------------------------------------------------------------------------------------------------------
    "organization-plans-home" => "$views\Plans\Home\index",
    "organization-plans-list" => "$views\Plans\List\index",
    "organization-plans-view" => "$views\Plans\View\index",
    "organization-plans-create" => "$views\Plans\Create\index",
    "organization-plans-edit" => "$views\Plans\Edit\index",
    "organization-plans-delete" => "$views\Plans\Delete\index",
    //[Macroprocesses]--------------------------------------------------------------------------------------------------
    "organization-macroprocesses-home" => "$views\Macroprocesses\Home\index",
    "organization-macroprocesses-list" => "$views\Macroprocesses\List\index",
    "organization-macroprocesses-view" => "$views\Macroprocesses\View\index",
    "organization-macroprocesses-create" => "$views\Macroprocesses\Create\index",
    "organization-macroprocesses-edit" => "$views\Macroprocesses\Edit\index",
    "organization-macroprocesses-delete" => "$views\Macroprocesses\Delete\index",
    //[Processes]-------------------------------------------------------------------------------------------------------
    "organization-processes-home" => "$views\Processes\Home\index",
    "organization-processes-list" => "$views\Processes\List\index",
    "organization-processes-view" => "$views\Processes\View\index",
    "organization-processes-create" => "$views\Processes\Create\index",
    "organization-processes-edit" => "$views\Processes\Edit\index",
    "organization-processes-delete" => "$views\Processes\Delete\index",
    //[Subprocesses]----------------------------------------------------------------------------------------------------
    "organization-subprocesses-home" => "$views\Subprocesses\Home\index",
    "organization-subprocesses-list" => "$views\Subprocesses\List\index",
    "organization-subprocesses-view" => "$views\Subprocesses\View\index",
    "organization-subprocesses-create" => "$views\Subprocesses\Create\index",
    "organization-subprocesses-edit" => "$views\Subprocesses\Edit\index",
    "organization-subprocesses-delete" => "$views\Subprocesses\Delete\index",
    //[Positions]----------------------------------------------------------------------------------------
    "organization-positions-home" => "$views\Positions\Home\index",
    "organization-positions-list" => "$views\Positions\List\index",
    "organization-positions-view" => "$views\Positions\View\index",
    "organization-positions-create" => "$views\Positions\Create\index",
    "organization-positions-edit" => "$views\Positions\Edit\index",
    "organization-positions-delete" => "$views\Positions\Delete\index",
    //[Characterization]------------------------------------------------------------------------------------------------
    "organization-characterization-view" => "$views\Characterization\View\index",
    //"organization-characterization-create" => "$views\Characterization\Create\index",
    "organization-characterization-edit" => "$views\Characterization\Edit\index",
    //"organization-characterization-delete" => "$views\Characterization\Delete\index",
    //"organization-characterization-list" => "$views\Characterization\List\index",
    //[others]----------------------------------------------------------------------------------------------------------
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
$assign['left'] = get_organization_sidebar();
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
