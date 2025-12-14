<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Helpdesk') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "helpdesk-home" => "{$views}\Home\index",
    "helpdesk-denied" => "{$views}\Denied\index",
    //[Services]--------------------------------------------------------------------------------------------------------
    "helpdesk-services-home" => "{$views}\Services\Home\index",
    "helpdesk-services-list" => "{$views}\Services\List\index",
    "helpdesk-services-view" => "{$views}\Services\View\index",
    "helpdesk-services-create" => "{$views}\Services\Create\index",
    "helpdesk-services-edit" => "{$views}\Services\Edit\index",
    "helpdesk-services-delete" => "{$views}\Services\Delete\index",
    //[Agents]----------------------------------------------------------------------------------------------------------
    "helpdesk-agents-home" => "{$views}\Agents\Home\index",
    "helpdesk-agents-list" => "{$views}\Agents\List\index",
    "helpdesk-agents-view" => "{$views}\Agents\View\index",
    "helpdesk-agents-create" => "{$views}\Agents\Create\index",
    "helpdesk-agents-edit" => "{$views}\Agents\Edit\index",
    "helpdesk-agents-delete" => "{$views}\Agents\Delete\index",
    //[Conversations]---------------------------------------------------------------------------------------------------
    "helpdesk-conversations-home" => "{$views}\Conversations\Home\index",
    "helpdesk-conversations-list" => "{$views}\Conversations\List\index",
    "helpdesk-conversations-view" => "{$views}\Conversations\View\index",
    "helpdesk-conversations-review" => "{$views}\Conversations\Review\index",
    "helpdesk-conversations-create" => "{$views}\Conversations\Create\index",
    "helpdesk-conversations-edit" => "{$views}\Conversations\Edit\index",
    "helpdesk-conversations-delete" => "{$views}\Conversations\Delete\index",
    //[Messages]--------------------------------------------------------------------------------------------------------
    "helpdesk-messages-home" => "{$views}\Messages\Home\index",
    "helpdesk-messages-list" => "{$views}\Messages\List\index",
    "helpdesk-messages-view" => "{$views}\Messages\View\index",
    "helpdesk-messages-create" => "{$views}\Messages\Create\index",
    "helpdesk-messages-edit" => "{$views}\Messages\Edit\index",
    "helpdesk-messages-delete" => "{$views}\Messages\Delete\index",
    //[Types]-----------------------------------------------------------------------------------------------------------
    "helpdesk-types-home" => "{$views}\Types\Home\index",
    "helpdesk-types-list" => "{$views}\Types\List\index",
    "helpdesk-types-view" => "{$views}\Types\View\index",
    "helpdesk-types-create" => "{$views}\Types\Create\index",
    "helpdesk-types-edit" => "{$views}\Types\Edit\index",
    "helpdesk-types-delete" => "{$views}\Types\Delete\index",
    //[Categories]------------------------------------------------------------------------------------------------------
    "helpdesk-categories-home" => "{$views}\Categories\Home\index",
    "helpdesk-categories-list" => "{$views}\Categories\List\index",
    "helpdesk-categories-view" => "{$views}\Categories\View\index",
    "helpdesk-categories-create" => "{$views}\Categories\Create\index",
    "helpdesk-categories-edit" => "{$views}\Categories\Edit\index",
    "helpdesk-categories-delete" => "{$views}\Categories\Delete\index",
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
$assign['left'] = get_helpdesk_sidebar();
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
