<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = safe_round(($server->get_DirectorySize(APPPATH . 'Modules/Iris') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "iris-denied" => "{$views}\Denied\index",
    "iris-home" => "{$views}\Home\index",
    //[patients]----------------------------------------------------------------------------------------
    "iris-patients-home" => "$views\Patients\Home\index",
    "iris-patients-list" => "$views\Patients\List\index",
    "iris-patients-view" => "$views\Patients\View\index",
    "iris-patients-create" => "$views\Patients\Create\index",
    "iris-patients-edit" => "$views\Patients\Edit\index",
    "iris-patients-delete" => "$views\Patients\Delete\index",
    //[Episode]----------------------------------------------------------------------------------------
    "iris-episodes-home" => "$views\Episodes\Home\index",
    "iris-episodes-list" => "$views\Episodes\List\index",
    "iris-episodes-view" => "$views\Episodes\View\index",
    "iris-episodes-create" => "$views\Episodes\Create\index",
    "iris-episodes-edit" => "$views\Episodes\Edit\index",
    "iris-episodes-delete" => "$views\Episodes\Delete\index",
    //[studies]----------------------------------------------------------------------------------------
    "iris-studies-home" => "$views\Studies\Home\index",
    "iris-studies-list" => "$views\Studies\List\index",
    "iris-studies-view" => "$views\Studies\View\index",
    "iris-studies-create" => "$views\Studies\Create\index",
    "iris-studies-edit" => "$views\Studies\Edit\index",
    "iris-studies-delete" => "$views\Studies\Delete\index",
    "iris-studies-ia" => "$views\Studies\Ia\index",
    //[Image]----------------------------------------------------------------------------------------
    "iris-images-home" => "$views\Images\Home\index",
    "iris-images-list" => "$views\Images\List\index",
    "iris-images-view" => "$views\Images\View\index",
    "iris-images-create" => "$views\Images\Create\index",
    "iris-images-edit" => "$views\Images\Edit\index",
    "iris-images-delete" => "$views\Images\Delete\index",
    //[Diagnostics]----------------------------------------------------------------------------------------
    "iris-diagnostics-home" => "$views\Diagnostics\Home\index",
    "iris-diagnostics-list" => "$views\Diagnostics\List\index",
    "iris-diagnostics-view" => "$views\Diagnostics\View\index",
    "iris-diagnostics-create" => "$views\Diagnostics\Create\index",
    "iris-diagnostics-edit" => "$views\Diagnostics\Edit\index",
    "iris-diagnostics-delete" => "$views\Diagnostics\Delete\index",
    //[Settings]----------------------------------------------------------------------------------------
    "iris-settings-home" => "$views\Settings\Home\index",
    "iris-settings-list" => "$views\Settings\List\index",
    "iris-settings-view" => "$views\Settings\View\index",
    "iris-settings-create" => "$views\Settings\Create\index",
    "iris-settings-edit" => "$views\Settings\Edit\index",
    "iris-settings-delete" => "$views\Settings\Delete\index",
    //[Modalities]----------------------------------------------------------------------------------------
    "iris-modalities-home" => "$views\Modalities\Home\index",
    "iris-modalities-list" => "$views\Modalities\List\index",
    "iris-modalities-view" => "$views\Modalities\View\index",
    "iris-modalities-create" => "$views\Modalities\Create\index",
    "iris-modalities-edit" => "$views\Modalities\Edit\index",
    "iris-modalities-delete" => "$views\Modalities\Delete\index",
    //[Procedures]----------------------------------------------------------------------------------------
    "iris-procedures-home" => "$views\Procedures\Home\index",
    "iris-procedures-list" => "$views\Procedures\List\index",
    "iris-procedures-view" => "$views\Procedures\View\index",
    "iris-procedures-create" => "$views\Procedures\Create\index",
    "iris-procedures-edit" => "$views\Procedures\Edit\index",
    "iris-procedures-delete" => "$views\Procedures\Delete\index",
    //[Categories]----------------------------------------------------------------------------------------
    "iris-categories-home" => "$views\Categories\Home\index",
    "iris-categories-list" => "$views\Categories\List\index",
    "iris-categories-view" => "$views\Categories\View\index",
    "iris-categories-create" => "$views\Categories\Create\index",
    "iris-categories-edit" => "$views\Categories\Edit\index",
    "iris-categories-delete" => "$views\Categories\Delete\index",
    //[Mstudies]----------------------------------------------------------------------------------------
    "iris-mstudies-home" => "$views\Mstudies\Home\index",
    "iris-mstudies-list" => "$views\Mstudies\List\index",
    "iris-mstudies-view" => "$views\Mstudies\View\index",
    "iris-mstudies-create" => "$views\Mstudies\Create\index",
    "iris-mstudies-edit" => "$views\Mstudies\Edit\index",
    "iris-mstudies-delete" => "$views\Mstudies\Delete\index",
    //[Specialties]----------------------------------------------------------------------------------------
	"iris-specialties-home"=>"$views\Specialties\Home\index",
	"iris-specialties-list"=>"$views\Specialties\List\index",
	"iris-specialties-view"=>"$views\Specialties\View\index",
	"iris-specialties-create"=>"$views\Specialties\Create\index",
	"iris-specialties-edit"=>"$views\Specialties\Edit\index",
	"iris-specialties-delete"=>"$views\Specialties\Delete\index",
    //[Groups]----------------------------------------------------------------------------------------
    "iris-groups-home"=>"$views\Groups\Home\index",
    "iris-groups-list"=>"$views\Groups\List\index",
    "iris-groups-view"=>"$views\Groups\View\index",
    "iris-groups-create"=>"$views\Groups\Create\index",
    "iris-groups-edit"=>"$views\Groups\Edit\index",
    "iris-groups-delete"=>"$views\Groups\Delete\index",
    //[others]------------------------------------------------------------------------------------------
);
$uri = !isset($rviews[$prefix]) ? $rviews["default"] : $rviews[$prefix];
$json = view($uri, $data);
//[build]---------------------------------------------------------------------------------------------------------------
$assign = array();
$assign['theme'] = "Higgs";
$assign['main_template'] = safe_json($json, 'main_template', "c9c3");
$assign['breadcrumb'] = safe_json($json, 'breadcrumb');
$assign['main'] = safe_json($json, 'main');
$assign['left'] = get_iris_sidebar2();
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
$assign['modals'] = safe_module_modal();
$assign['benchmark'] = $benchmark->getElapsedTime('time', 4);
$assign['version'] = $version;
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Gamma\index", $assign);
echo($template);
?>