<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Standards') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "standards-denied" => "{$views}\Denied\index",
    "standards-home" => "{$views}\Home\index",
    //[Objects]---------------------------------------------------------------------------------------------------------
    "standards-objects-home"=>"$views\Objects\Home\index",
    "standards-objects-list"=>"$views\Objects\List\index",
    "standards-objects-view"=>"$views\Objects\View\index",
    "standards-objects-create"=>"$views\Objects\Create\index",
    "standards-objects-edit"=>"$views\Objects\Edit\index",
    "standards-objects-delete"=>"$views\Objects\Delete\index",
    //[Categories]------------------------------------------------------------------------------------------------------
    "standards-categories-home"=>"$views\Categories\Home\index",
    "standards-categories-list"=>"$views\Categories\List\index",
    "standards-categories-view"=>"$views\Categories\View\index",
    "standards-categories-create"=>"$views\Categories\Create\index",
    "standards-categories-edit"=>"$views\Categories\Edit\index",
    "standards-categories-delete"=>"$views\Categories\Delete\index",
    //[Scores]----------------------------------------------------------------------------------------
    "standards-scores-home"=>"$views\Scores\Home\index",
    "standards-scores-list"=>"$views\Scores\List\index",
    "standards-scores-view"=>"$views\Scores\View\index",
    "standards-scores-create"=>"$views\Scores\Create\index",
    "standards-scores-edit"=>"$views\Scores\Edit\index",
    "standards-scores-delete"=>"$views\Scores\Delete\index",
    //[others]----------------------------------------------------------------------------------------------------------
    "standards-settings-home"=>"$views\Settings\Home\index",
);
$uri = !isset($rviews[$prefix]) ? $rviews["default"] : $rviews[$prefix];
$json = view($uri, $data);
$mmu = model("App\Modules\Messenger\Models\Messenger_Users");
//[build]---------------------------------------------------------------------------------------------------------------
$assign = array();
$assign['theme'] = "Higgs";
$assign['main_template'] = safe_json($json, 'main_template', "c9c3");
$assign['breadcrumb'] = safe_json($json, 'breadcrumb');
$assign['main'] = safe_json($json, 'main');
$assign['left'] = get_standards_sidebar2();
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
$assign['modals'] =safe_module_modal();
$assign['benchmark'] = $benchmark->getElapsedTime('time', 4);
$assign['version'] = $version;
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Gamma\index", $assign);
echo($template);
?>