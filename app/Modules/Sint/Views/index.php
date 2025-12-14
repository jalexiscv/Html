<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Sint') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "sint-denied" => "{$views}\Denied\index",
    "sint-home" => "{$views}\Home\index",
    //[cases]-----------------------------------------------------------------------------------------------------------
    "sint-cases-home" => "$views\Cases\Home\index",
    "sint-cases-list" => "$views\Cases\List\index",
    "sint-cases-view" => "$views\Cases\View\index",
    "sint-cases-create" => "$views\Cases\Create\index",
    "sint-cases-edit" => "$views\Cases\Edit\index",
    "sint-cases-delete" => "$views\Cases\Delete\index",
    //[Incidents]----------------------------------------------------------------------------------------
    "sint-incidents-home" => "$views\Incidents\Home\index",
    "sint-incidents-list" => "$views\Incidents\List\index",
    "sint-incidents-view" => "$views\Incidents\View\index",
    "sint-incidents-create" => "$views\Incidents\Create\index",
    "sint-incidents-edit" => "$views\Incidents\Edit\index",
    "sint-incidents-delete" => "$views\Incidents\Delete\index",
    //[settings]----------------------------------------------------------------------------------------
    "sint-settings-home" => "$views\Settings\Home\index",
    //[Breaches]----------------------------------------------------------------------------------------
    "sint-breaches-home" => "$views\Breaches\Home\index",
    "sint-breaches-list" => "$views\Breaches\List\index",
    "sint-breaches-view" => "$views\Breaches\View\index",
    "sint-breaches-create" => "$views\Breaches\Create\index",
    "sint-breaches-edit" => "$views\Breaches\Edit\index",
    "sint-breaches-delete" => "$views\Breaches\Delete\index",
    //[importers]-------------------------------------------------------------------------------------------------------
    "sint-importers-breaches" => "$views\Importers\Breaches\index",
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
$assign['left'] = get_sint_sidebar();
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
