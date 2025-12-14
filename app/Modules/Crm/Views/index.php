<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$data = $parent->get_Array();
$data['version'] = round(($server->get_DirectorySize(APPPATH . 'Modules/Security') / 102400), 4);
$rviews = array(
    "default" => "$views\E404\index",
    "crm-denied" => "$views\Denied\index",
    "crm-home" => "$views\Home\index",
    "crm-tools-home" => "$views\Tools\Home\index",
    "crm-tools-texttophp-generator" => "$views\Tools\Texttophp\Generator\index",
    "crm-generators-list" => "$views\Generators\List\index",
    //[Agents]----------------------------------------------------------------------------------------------------------
    "crm-agents-home" => "$views\Agents\Home\index",
    "crm-agents-list" => "$views\Agents\List\index",
    "crm-agents-view" => "$views\Agents\View\index",
    "crm-agents-create" => "$views\Agents\Create\index",
    "crm-agents-edit" => "$views\Agents\Edit\index",
    "crm-agents-delete" => "$views\Agents\Delete\index",
    //[Appointments]----------------------------------------------------------------------------------------------------
    "crm-appointments-home" => "$views\Appointments\Home\index",
    "crm-appointments-list" => "$views\Appointments\List\index",
    "crm-appointments-view" => "$views\Appointments\View\index",
    "crm-appointments-create" => "$views\Appointments\Create\index",
    "crm-appointments-edit" => "$views\Appointments\Edit\index",
    "crm-appointments-delete" => "$views\Appointments\Delete\index",
    //[Tickets]---------------------------------------------------------------------------------------------------------
    "crm-tickets-home" => "$views\Tickets\Home\index",
    "crm-tickets-list" => "$views\Tickets\List\index",
    "crm-tickets-view" => "$views\Tickets\View\index",
    "crm-tickets-create" => "$views\Tickets\Create\index",
    "crm-tickets-edit" => "$views\Tickets\Edit\index",
    "crm-tickets-delete" => "$views\Tickets\Delete\index",
    "crm-tickets-fullscreen" => "$views\Tickets\Fullscreen\index",
    "crm-tickets-screen" => "$views\Tickets\Screen\index",
    "crm-tickets-attend" => "$views\Tickets\Attend\index",
    //[Reports]-----------------------------------------------------------------------------------------------------------
    "crm-reports-home" => "$views\Reports\Home\index",
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
$assign['left'] = get_crm_sidebar();
$assign['right'] = safe_json($json, 'right') . get_application_copyright();
$assign['logo_portrait'] = get_logo("logo_portrait");
$assign['logo_landscape'] = get_logo('logo_landscape');
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
$assign['messenger_users'] = $mmu->get_OnlineUsers(100, 0);
$benchmark->stop('time');
$assign['benchmark'] = $benchmark->getElapsedTime('time', 4);
$assign['version'] = $data['version'];
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Higgs\index", $assign);
echo($template);
?>