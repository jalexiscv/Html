<?php

/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Cms') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "cms-denied" => "{$views}\Denied\index",
    "cms-home" => "{$views}\Home\index",
    //[Asigns]----------------------------------------------------------------------------------------
    "cms-asigns-home" => "$views\Asigns\Home\index",
    "cms-asigns-list" => "$views\Asigns\List\index",
    "cms-asigns-view" => "$views\Asigns\View\index",
    "cms-asigns-create" => "$views\Asigns\Create\index",
    "cms-asigns-edit" => "$views\Asigns\Edit\index",
    "cms-asigns-delete" => "$views\Asigns\Delete\index",
    //[Blocks]----------------------------------------------------------------------------------------
    "cms-blocks-home" => "$views\Blocks\Home\index",
    "cms-blocks-list" => "$views\Blocks\List\index",
    "cms-blocks-view" => "$views\Blocks\View\index",
    "cms-blocks-create" => "$views\Blocks\Create\index",
    "cms-blocks-edit" => "$views\Blocks\Edit\index",
    "cms-blocks-delete" => "$views\Blocks\Delete\index",
    //[Components]----------------------------------------------------------------------------------------
    "cms-components-home" => "$views\Components\Home\index",
    "cms-components-list" => "$views\Components\List\index",
    "cms-components-view" => "$views\Components\View\index",
    "cms-components-create" => "$views\Components\Create\index",
    "cms-components-edit" => "$views\Components\Edit\index",
    "cms-components-delete" => "$views\Components\Delete\index",
    //[Files]----------------------------------------------------------------------------------------
    "cms-files-home" => "$views\Files\Home\index",
    "cms-files-list" => "$views\Files\List\index",
    "cms-files-view" => "$views\Files\View\index",
    "cms-files-create" => "$views\Files\Create\index",
    "cms-files-edit" => "$views\Files\Edit\index",
    "cms-files-delete" => "$views\Files\Delete\index",
    //[Links]----------------------------------------------------------------------------------------
    "cms-links-home" => "$views\Links\Home\index",
    "cms-links-list" => "$views\Links\List\index",
    "cms-links-view" => "$views\Links\View\index",
    "cms-links-create" => "$views\Links\Create\index",
    "cms-links-edit" => "$views\Links\Edit\index",
    "cms-links-delete" => "$views\Links\Delete\index",
    //[Menus]----------------------------------------------------------------------------------------
    "cms-menus-home" => "$views\Menus\Home\index",
    "cms-menus-list" => "$views\Menus\List\index",
    "cms-menus-view" => "$views\Menus\View\index",
    "cms-menus-create" => "$views\Menus\Create\index",
    "cms-menus-edit" => "$views\Menus\Edit\index",
    "cms-menus-delete" => "$views\Menus\Delete\index",
    //[Metatags]----------------------------------------------------------------------------------------
    "cms-metatags-home" => "$views\Metatags\Home\index",
    "cms-metatags-list" => "$views\Metatags\List\index",
    "cms-metatags-view" => "$views\Metatags\View\index",
    "cms-metatags-create" => "$views\Metatags\Create\index",
    "cms-metatags-edit" => "$views\Metatags\Edit\index",
    "cms-metatags-delete" => "$views\Metatags\Delete\index",
    //[Posts]----------------------------------------------------------------------------------------
    "cms-posts-home" => "$views\Posts\Home\index",
    "cms-posts-list" => "$views\Posts\List\index",
    "cms-posts-view" => "$views\Posts\View\index",
    "cms-posts-create" => "$views\Posts\Create\index",
    "cms-posts-edit" => "$views\Posts\Edit\index",
    "cms-posts-delete" => "$views\Posts\Delete\index",
    //[Settings]----------------------------------------------------------------------------------------
    "cms-settings-home" => "$views\Settings\Home\index",
    "cms-settings-list" => "$views\Settings\List\index",
    "cms-settings-view" => "$views\Settings\View\index",
    "cms-settings-create" => "$views\Settings\Create\index",
    "cms-settings-edit" => "$views\Settings\Edit\index",
    "cms-settings-delete" => "$views\Settings\Delete\index",
    //[Typefiles]----------------------------------------------------------------------------------------
    "cms-typefiles-home" => "$views\Typefiles\Home\index",
    "cms-typefiles-list" => "$views\Typefiles\List\index",
    "cms-typefiles-view" => "$views\Typefiles\View\index",
    "cms-typefiles-create" => "$views\Typefiles\Create\index",
    "cms-typefiles-edit" => "$views\Typefiles\Edit\index",
    "cms-typefiles-delete" => "$views\Typefiles\Delete\index",
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
$assign['left'] = get_cms_sidebar();
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