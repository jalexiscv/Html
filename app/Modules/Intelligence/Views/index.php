<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Intelligence') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "intelligence-denied" => "{$views}\Denied\index",
    "intelligence-home" => "{$views}\Home\index",
    //[settings]--------------------------------------------------------------------------------------------------------
    "intelligence-settings-home" => "{$views}\Settings\Home\index",
    "intelligence-settings-personalities" => "{$views}\Settings\Personalities\index",
    //[personalities]---------------------------------------------------------------------------------------------------
    "intelligence-personalities-home" => "$views\Personalities\Home\index",
    "intelligence-personalities-list" => "$views\Personalities\List\index",
    "intelligence-personalities-view" => "$views\Personalities\View\index",
    "intelligence-personalities-create" => "$views\Personalities\Create\index",
    "intelligence-personalities-edit" => "$views\Personalities\Edit\index",
    "intelligence-personalities-delete" => "$views\Personalities\Delete\index",
    //[instructions]----------------------------------------------------------------------------------------------------
    "intelligence-instructions-home" => "$views\Instructions\Home\index",
    "intelligence-instructions-list" => "$views\Instructions\List\index",
    "intelligence-instructions-view" => "$views\Instructions\View\index",
    "intelligence-instructions-create" => "$views\Instructions\Create\index",
    "intelligence-instructions-edit" => "$views\Instructions\Edit\index",
    "intelligence-instructions-delete" => "$views\Instructions\Delete\index",
    //[test]------------------------------------------------------------------------------------------------------------
    "application-ias-test-claude" => "$views\Test\Claude\index",
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
$assign['left'] = get_intelligence_sidebar();
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