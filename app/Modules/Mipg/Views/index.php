<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Mipg') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "mipg-denied" => "{$views}\Denied\index",
    "mipg-home" => "{$views}\Home\index",
    //[Dimensions]------------------------------------------------------------------------------------------------------
    "mipg-dimensions-home" => "$views\Dimensions\Home\index",
    "mipg-dimensions-list" => "$views\Dimensions\List\index",
    "mipg-dimensions-view" => "$views\Dimensions\View\index",
    "mipg-dimensions-create" => "$views\Dimensions\Create\index",
    "mipg-dimensions-edit" => "$views\Dimensions\Edit\index",
    "mipg-dimensions-delete" => "$views\Dimensions\Delete\index",
    //[Politics]--------------------------------------------------------------------------------------------------------
    "mipg-politics-home" => "$views\Politics\Home\index",
    "mipg-politics-list" => "$views\Politics\List\index",
    "mipg-politics-view" => "$views\Politics\View\index",
    "mipg-politics-create" => "$views\Politics\Create\index",
    "mipg-politics-edit" => "$views\Politics\Edit\index",
    "mipg-politics-delete" => "$views\Politics\Delete\index",
    //[Diagnostics]-----------------------------------------------------------------------------------------------------
    "mipg-diagnostics-home" => "$views\Diagnostics\Home\index",
    "mipg-diagnostics-list" => "$views\Diagnostics\List\index",
    "mipg-diagnostics-view" => "$views\Diagnostics\View\index",
    "mipg-diagnostics-create" => "$views\Diagnostics\Create\index",
    "mipg-diagnostics-edit" => "$views\Diagnostics\Edit\index",
    "mipg-diagnostics-delete" => "$views\Diagnostics\Delete\index",
    //[Components]------------------------------------------------------------------------------------------------------
    "mipg-components-home" => "$views\Components\Home\index",
    "mipg-components-list" => "$views\Components\List\index",
    "mipg-components-view" => "$views\Components\View\index",
    "mipg-components-create" => "$views\Components\Create\index",
    "mipg-components-edit" => "$views\Components\Edit\index",
    "mipg-components-delete" => "$views\Components\Delete\index",
    //[Categories]------------------------------------------------------------------------------------------------------
    "mipg-categories-home" => "$views\Categories\Home\index",
    "mipg-categories-list" => "$views\Categories\List\index",
    "mipg-categories-view" => "$views\Categories\View\index",
    "mipg-categories-create" => "$views\Categories\Create\index",
    "mipg-categories-edit" => "$views\Categories\Edit\index",
    "mipg-categories-delete" => "$views\Categories\Delete\index",
    //[Activities]------------------------------------------------------------------------------------------------------
    "mipg-activities-home" => "$views\Activities\Home\index",
    "mipg-activities-list" => "$views\Activities\List\index",
    "mipg-activities-view" => "$views\Activities\View\index",
    "mipg-activities-create" => "$views\Activities\Create\index",
    "mipg-activities-edit" => "$views\Activities\Edit\index",
    "mipg-activities-delete" => "$views\Activities\Delete\index",
    //[Scores]----------------------------------------------------------------------------------------------------------
    "mipg-scores-home" => "$views\Scores\Home\index",
    "mipg-scores-list" => "$views\Scores\List\index",
    "mipg-scores-view" => "$views\Scores\View\index",
    "mipg-scores-create" => "$views\Scores\Create\index",
    "mipg-scores-edit" => "$views\Scores\Edit\index",
    "mipg-scores-delete" => "$views\Scores\Delete\index",
    //[Plans]----------------------------------------------------------------------------------------------------------
    "mipg-plans-home" => "$views\Plans\Home\index",
    "mipg-plans-list" => "$views\Plans\List\index",
    "mipg-plans-view" => "$views\Plans\View\index",
    "mipg-plans-create" => "$views\Plans\Create\index",
    "mipg-plans-edit" => "$views\Plans\Edit\index",
    "mipg-plans-delete" => "$views\Plans\Delete\index",
    "mipg-plans-details" => "$views\Plans\Details\index",
    "mipg-plans-team" => "$views\Plans\Team\index",
    "mipg-plans-causes" => "$views\Plans\Causes\index",
    "mipg-plans-formulation" => "$views\Plans\Formulation\index",
    "mipg-plans-actions" => "$views\Plans\Actions\index",
    "mipg-plans-approval" => "$views\Plans\Approval\index",
    "mipg-plans-approve" => "$views\Plans\Approve\index",
    "mipg-plans-evaluate" => "$views\Plans\Evaluate\index",
    "mipg-plans-evaluation" => "$views\Plans\Evaluation\index",
    "mipg-plans-risks" => "$views\Plans\Risks\index",
    //[Causes]----------------------------------------------------------------------------------------------------------
    "mipg-causes-home" => "$views\Causes\Home\index",
    "mipg-causes-list" => "$views\Causes\List\index",
    "mipg-causes-view" => "$views\Causes\View\index",
    "mipg-causes-create" => "$views\Causes\Create\index",
    "mipg-causes-edit" => "$views\Causes\Edit\index",
    "mipg-causes-delete" => "$views\Causes\Delete\index",
    //[Evaluate]--------------------------------------------------------------------------------------------------------
    "mipg-evaluate-causes" => "$views\Evaluate\Causes\index",
    //[Whys]------------------------------------------------------------------------------------------------------------
    "mipg-whys-home" => "$views\Whys\Home\index",
    "mipg-whys-list" => "$views\Whys\List\index",
    "mipg-whys-view" => "$views\Whys\View\index",
    "mipg-whys-create" => "$views\Whys\Create\index",
    "mipg-whys-edit" => "$views\Whys\Edit\index",
    "mipg-whys-delete" => "$views\Whys\Delete\index",
    //[Formulation]-----------------------------------------------------------------------------------------------------
    "mipg-formulation-home" => "$views\Formulation\Home\index",
    "mipg-formulation-list" => "$views\Formulation\List\index",
    "mipg-formulation-view" => "$views\Formulation\View\index",
    "mipg-formulation-create" => "$views\Formulation\Create\index",
    "mipg-formulation-edit" => "$views\Formulation\Edit\index",
    "mipg-formulation-delete" => "$views\Formulation\Delete\index",
    //[Formulation]-----------------------------------------------------------------------------------------------------
    "mipg-actions-home" => "$views\Actions\Home\index",
    "mipg-actions-list" => "$views\Actions\List\index",
    "mipg-actions-view" => "$views\Actions\View\index",
    "mipg-actions-create" => "$views\Actions\Create\index",
    "mipg-actions-edit" => "$views\Actions\Edit\index",
    "mipg-actions-delete" => "$views\Actions\Delete\index",
    //[control]---------------------------------------------------------------------------------------------------------
    "mipg-control-home" => "$views\Control\Home\index",
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
$assign['left'] = get_mipg_sidebar();
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
