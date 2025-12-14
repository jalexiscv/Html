<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Sgd') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "sgd-denied" => "{$views}\Denied\index",
    "sgd-home" => "{$views}\Home\index",
    //[Series]----------------------------------------------------------------------------------------------------------
    "sgd-series-home" => "$views\Series\Home\index",
    "sgd-series-list" => "$views\Series\List\index",
    "sgd-series-view" => "$views\Series\View\index",
    "sgd-series-create" => "$views\Series\Create\index",
    "sgd-series-edit" => "$views\Series\Edit\index",
    "sgd-series-delete" => "$views\Series\Delete\index",
    //[Subseries]-------------------------------------------------------------------------------------------------------
    "sgd-subseries-home" => "$views\Subseries\Home\index",
    "sgd-subseries-list" => "$views\Subseries\List\index",
    "sgd-subseries-view" => "$views\Subseries\View\index",
    "sgd-subseries-create" => "$views\Subseries\Create\index",
    "sgd-subseries-edit" => "$views\Subseries\Edit\index",
    "sgd-subseries-delete" => "$views\Subseries\Delete\index",
    //[Metatags]--------------------------------------------------------------------------------------------------------
    "sgd-metatags-home" => "$views\Metatags\Home\index",
    "sgd-metatags-list" => "$views\Metatags\List\index",
    "sgd-metatags-view" => "$views\Metatags\View\index",
    "sgd-metatags-create" => "$views\Metatags\Create\index",
    "sgd-metatags-edit" => "$views\Metatags\Edit\index",
    "sgd-metatags-delete" => "$views\Metatags\Delete\index",
    //[Versions]--------------------------------------------------------------------------------------------------------
    "sgd-versions-home" => "$views\Versions\Home\index",
    "sgd-versions-list" => "$views\Versions\List\index",
    "sgd-versions-view" => "$views\Versions\View\index",
    "sgd-versions-create" => "$views\Versions\Create\index",
    "sgd-versions-edit" => "$views\Versions\Edit\index",
    "sgd-versions-delete" => "$views\Versions\Delete\index",
    //[Units]-----------------------------------------------------------------------------------------------------------
    "sgd-units-home" => "$views\Units\Home\index",
    "sgd-units-list" => "$views\Units\List\index",
    "sgd-units-view" => "$views\Units\View\index",
    "sgd-units-create" => "$views\Units\Create\index",
    "sgd-units-edit" => "$views\Units\Edit\index",
    "sgd-units-delete" => "$views\Units\Delete\index",
    //[Registrations]---------------------------------------------------------------------------------------------------
    "sgd-registrations-home" => "$views\Registrations\Home\index",
    "sgd-registrations-list" => "$views\Registrations\List\index",
    "sgd-registrations-view" => "$views\Registrations\View\index",
    "sgd-registrations-create" => "$views\Registrations\Create\index",
    "sgd-registrations-edit" => "$views\Registrations\Edit\index",
    "sgd-registrations-delete" => "$views\Registrations\Delete\index",
    "sgd-registrations-print" => "$views\Registrations\Print\index",
    "sgd-registrations-print2" => "$views\Registrations\Print2\index",
    "sgd-registrations-external" => "$views\Registrations\External\index",
    //[Centers]----------------------------------------------------------------------------------------
    "sgd-centers-home"=>"$views\Centers\Home\index",
    "sgd-centers-list"=>"$views\Centers\List\index",
    "sgd-centers-view"=>"$views\Centers\View\index",
    "sgd-centers-create"=>"$views\Centers\Create\index",
    "sgd-centers-edit"=>"$views\Centers\Edit\index",
    "sgd-centers-delete"=>"$views\Centers\Delete\index",
    //[Shelves]----------------------------------------------------------------------------------------
    "sgd-shelves-home"=>"$views\Shelves\Home\index",
    "sgd-shelves-list"=>"$views\Shelves\List\index",
    "sgd-shelves-view"=>"$views\Shelves\View\index",
    "sgd-shelves-create"=>"$views\Shelves\Create\index",
    "sgd-shelves-edit"=>"$views\Shelves\Edit\index",
    "sgd-shelves-delete"=>"$views\Shelves\Delete\index",
    //[Boxes]----------------------------------------------------------------------------------------
    "sgd-boxes-home"=>"$views\Boxes\Home\index",
    "sgd-boxes-list"=>"$views\Boxes\List\index",
    "sgd-boxes-view"=>"$views\Boxes\View\index",
    "sgd-boxes-create"=>"$views\Boxes\Create\index",
    "sgd-boxes-edit"=>"$views\Boxes\Edit\index",
    "sgd-boxes-delete"=>"$views\Boxes\Delete\index",
    //[Folders]----------------------------------------------------------------------------------------
    "sgd-folders-home"=>"$views\Folders\Home\index",
    "sgd-folders-list"=>"$views\Folders\List\index",
    "sgd-folders-view"=>"$views\Folders\View\index",
    "sgd-folders-create"=>"$views\Folders\Create\index",
    "sgd-folders-edit"=>"$views\Folders\Edit\index",
    "sgd-folders-delete"=>"$views\Folders\Delete\index",
    //[Files]----------------------------------------------------------------------------------------
    "sgd-files-home"=>"$views\Files\Home\index",
    "sgd-files-list"=>"$views\Files\List\index",
    "sgd-files-view"=>"$views\Files\View\index",
    "sgd-files-create"=>"$views\Files\Create\index",
    "sgd-files-edit"=>"$views\Files\Edit\index",
    "sgd-files-delete"=>"$views\Files\Delete\index",
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
$assign['left'] = get_sgd_sidebar();
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
