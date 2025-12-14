<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "tdp-denied" => "{$views}\Denied\index",
    "tdp-home" => "{$views}\Home\index",
    //[dimensions]------------------------------------------------------------------------------------------------------
    "tdp-dimensions-home" => "$views\Dimensions\Home\index",
    "tdp-dimensions-list" => "$views\Dimensions\List\index",
    "tdp-dimensions-view" => "$views\Dimensions\View\index",
    "tdp-dimensions-create" => "$views\Dimensions\Create\index",
    "tdp-dimensions-edit" => "$views\Dimensions\Edit\index",
    "tdp-dimensions-delete" => "$views\Dimensions\Delete\index",
    //[lines]--------------------------------------------------------------------------------------------------------
    "tdp-lines-home" => "$views\Lines\Home\index",
    "tdp-lines-list" => "$views\Lines\List\index",
    "tdp-lines-view" => "$views\Lines\View\index",
    "tdp-lines-create" => "$views\Lines\Create\index",
    "tdp-lines-edit" => "$views\Lines\Edit\index",
    "tdp-lines-delete" => "$views\Lines\Delete\index",
    //[diagnostics]-----------------------------------------------------------------------------------------------------
    "tdp-diagnostics-home" => "$views\Diagnostics\Home\index",
    "tdp-diagnostics-list" => "$views\Diagnostics\List\index",
    "tdp-diagnostics-view" => "$views\Diagnostics\View\index",
    "tdp-diagnostics-create" => "$views\Diagnostics\Create\index",
    "tdp-diagnostics-edit" => "$views\Diagnostics\Edit\index",
    "tdp-diagnostics-delete" => "$views\Diagnostics\Delete\index",
    //[sectors]-----------------------------------------------------------------------------------------------------
    "tdp-sectors-home" => "$views\Sectors\Home\index",
    "tdp-sectors-list" => "$views\Sectors\List\index",
    "tdp-sectors-view" => "$views\Sectors\View\index",
    "tdp-sectors-create" => "$views\Sectors\Create\index",
    "tdp-sectors-edit" => "$views\Sectors\Edit\index",
    "tdp-sectors-delete" => "$views\Sectors\Delete\index",
    //[programs]-----------------------------------------------------------------------------------------------------
    "tdp-programs-home" => "$views\Programs\Home\index",
    "tdp-programs-list" => "$views\Programs\List\index",
    "tdp-programs-view" => "$views\Programs\View\index",
    "tdp-programs-create" => "$views\Programs\Create\index",
    "tdp-programs-edit" => "$views\Programs\Edit\index",
    "tdp-programs-delete" => "$views\Programs\Delete\index",
    //[products]-----------------------------------------------------------------------------------------------------
    "tdp-products-home" => "$views\Products\Home\index",
    "tdp-products-list" => "$views\Products\List\index",
    "tdp-products-view" => "$views\Products\View\index",
    "tdp-products-create" => "$views\Products\Create\index",
    "tdp-products-edit" => "$views\Products\Edit\index",
    "tdp-products-delete" => "$views\Products\Delete\index",
    //[indicators]-----------------------------------------------------------------------------------------------------
    "tdp-indicators-home" => "$views\Indicators\Home\index",
    "tdp-indicators-list" => "$views\Indicators\List\index",
    "tdp-indicators-view" => "$views\Indicators\View\index",
    "tdp-indicators-create" => "$views\Indicators\Create\index",
    "tdp-indicators-edit" => "$views\Indicators\Edit\index",
    "tdp-indicators-delete" => "$views\Indicators\Delete\index",

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
$assign['left'] = get_tdp_sidebar();
$assign['right'] = safe_json($json, 'right') . get_application_copyright();
$assign['logo_portrait'] = get_logo("logo_portrait");
$assign['logo_landscape'] = get_logo("logo_landscape");
$assign['logo_portrait_light'] = get_logo("logo_portrait_light");
$assign['logo_landscape_light'] = get_logo("logo_landscape_light");
$assign['type'] = safe_json($json, 'type');
$assign['canonical'] = safe_json($json, 'canonical');
$assign['title'] = safe_json($json, 'title');
$assign['description'] = safe_json($json, 'description');
$assign['programs'] = safe_json($json, 'programs');
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
$assign['version'] = round(($server->get_DirectorySize(APPPATH . 'Modules/Tdp') / 102400), 6);
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Higgs\index", $assign);
echo($template);
?>
