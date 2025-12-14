<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$data = $parent->get_Array();
$data["version"]= round(($server->get_DirectorySize(APPPATH . 'Modules/Plans') / 102400), 4);
$rviews = array(
    "default" => "$views\E404\index",
    "plans-denied" => "$views\Denied\index",
    //[plans]-----------------------------------------------------------------------------------------------------------
    "plans-plans-home" => "$views\Plans\Home\index",
    "plans-plans-list" => "$views\Plans\List\index",
    "plans-plans-view" => "$views\Plans\View\index",
    "plans-plans-create" => "$views\Plans\Create\index",
    "plans-plans-edit" => "$views\Plans\Edit\index",
    "plans-plans-delete" => "$views\Plans\Delete\index",
    "plans-plans-details" => "$views\Plans\Details\index",
    "plans-plans-team" => "$views\Plans\Team\index",
    "plans-plans-causes" => "$views\Plans\Causes\index",
    "plans-plans-formulation" => "$views\Plans\Formulation\index",
    "plans-plans-actions" => "$views\Plans\Actions\index",
    "plans-plans-approval" => "$views\Plans\Approval\index",
    "plans-plans-approve" => "$views\Plans\Approve\index",
    "plans-plans-evaluate" => "$views\Plans\Evaluate\index",
    "plans-plans-evaluation" => "$views\Plans\Evaluation\index",
    "plans-plans-risks" => "$views\Plans\Risks\index",
    //[causes]----------------------------------------------------------------------------------------------------------
    "plans-causes-create" => "$views\Causes\Create\index",
    "plans-causes-list" => "$views\Causes\List\index",
    "plans-causes-view" => "$views\Causes\View\index",
    "plans-causes-edit" => "$views\Causes\Edit\index",
    "plans-causes-delete" => "$views\Causes\Delete\index",
    //[causes-evaluate]-------------------------------------------------------------------------------------------------
    "plans-evaluate-causes" => "$views\Evaluate\Causes\index",
    //[whys]-----------------------------------------------------------------------------------------------------------
    "plans-whys-home" => "$views\Whys\Home\index",
    "plans-whys-list" => "$views\Whys\List\index",
    "plans-whys-view" => "$views\Whys\View\index",
    "plans-whys-create" => "$views\Whys\Create\index",
    "plans-whys-edit" => "$views\Whys\Edit\index",
    "plans-whys-delete" => "$views\Whys\Delete\index",
    //[formulation]-----------------------------------------------------------------------------------------------------
    "plans-formulation-home" => "$views\Formulation\Home\index",
    "plans-formulation-list" => "$views\Formulation\List\index",
    "plans-formulation-view" => "$views\Formulation\View\index",
    "plans-formulation-create" => "$views\Formulation\Create\index",
    "plans-formulation-edit" => "$views\Formulation\Edit\index",
    //[actions]---------------------------------------------------------------------------------------------------------
    "plans-actions-home" => "$views\Actions\Home\index",
    "plans-actions-list" => "$views\Actions\List\index",
    "plans-actions-view" => "$views\Actions\View\index",
    "plans-actions-create" => "$views\Actions\Create\index",
    "plans-actions-edit" => "$views\Actions\Edit\index",
    "plans-actions-delete" => "$views\Actions\Delete\index",
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
$assign['left'] = get_plans_sidebar2();
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
$assign['version'] = $data["version"];
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Gamma\index", $assign);
echo($template);
?>