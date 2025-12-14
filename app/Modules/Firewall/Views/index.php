<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Firewall') / 102400), 6);
$data = $parent->get_Array();
$rviews = array(
    "default" => "{$views}\E404\index",
    "firewall-denied" => "{$views}\Denied\index",
    "firewall-home" => "{$views}\Home\index",
    //[Livetraffic]-----------------------------------------------------------------------------------------------------
    "firewall-livetraffic-home" => "$views\Livetraffic\Home\index",
    "firewall-livetraffic-list" => "$views\Livetraffic\List\index",
    "firewall-livetraffic-view" => "$views\Livetraffic\View\index",
    "firewall-livetraffic-create" => "$views\Livetraffic\Create\index",
    "firewall-livetraffic-edit" => "$views\Livetraffic\Edit\index",
    "firewall-livetraffic-delete" => "$views\Livetraffic\Delete\index",
    //[Badbots]---------------------------------------------------------------------------------------------------------
    "firewall-badbots-home" => "$views\Badbots\Home\index",
    "firewall-badbots-list" => "$views\Badbots\List\index",
    "firewall-badbots-view" => "$views\Badbots\View\index",
    "firewall-badbots-create" => "$views\Badbots\Create\index",
    "firewall-badbots-edit" => "$views\Badbots\Edit\index",
    "firewall-badbots-delete" => "$views\Badbots\Delete\index",
    //[Bans]------------------------------------------------------------------------------------------------------------
    "firewall-bans-home" => "$views\Bans\Home\index",
    "firewall-bans-list" => "$views\Bans\List\index",
    "firewall-bans-view" => "$views\Bans\View\index",
    "firewall-bans-create" => "$views\Bans\Create\index",
    "firewall-bans-edit" => "$views\Bans\Edit\index",
    "firewall-bans-delete" => "$views\Bans\Delete\index",
    //[Filters]---------------------------------------------------------------------------------------------------------
    "firewall-filters-home" => "$views\Filters\Home\index",
    "firewall-filters-list" => "$views\Filters\List\index",
    "firewall-filters-view" => "$views\Filters\View\index",
    "firewall-filters-create" => "$views\Filters\Create\index",
    "firewall-filters-edit" => "$views\Filters\Edit\index",
    "firewall-filters-delete" => "$views\Filters\Delete\index",
    //[Whitelist]----------------------------------------------------------------------------------------
    "firewall-whitelist-home"=>"$views\Whitelist\Home\index",
    "firewall-whitelist-list"=>"$views\Whitelist\List\index",
    "firewall-whitelist-view"=>"$views\Whitelist\View\index",
    "firewall-whitelist-create"=>"$views\Whitelist\Create\index",
    "firewall-whitelist-edit"=>"$views\Whitelist\Edit\index",
    "firewall-whitelist-delete"=>"$views\Whitelist\Delete\index",
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
$assign['left'] = get_firewall_sidebar();
$assign['right'] = safe_json($json, 'right') .get_firewall_widget_myip(). get_application_copyright();
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
$assign['modals'] = safe_module_modal();
//[print]---------------------------------------------------------------------------------------------------------------
$template = view("App\Views\Themes\Beta\index", $assign);
echo($template);
?>