<?php
/** @var string $parent */
/** @var string $views */
/** @var string $prefix */
/** @var object $parent */
$server = service('server');
$benchmark = service('timer');
$benchmark->start('time');
$version = round(($server->get_DirectorySize(APPPATH . 'Modules/Security') / 102400), 6);
$data = $parent->get_Array();
//[views]---------------------------------------------------------------------------------------------------------------
$rviews = array(
    "default" => "{$views}\E404\index",
    "security-denied" => "{$views}\Denied\index",
    "security-home" => "{$views}\Home\index",
    "security-tools-home" => "{$views}\Tools\Home\index",
    "security-tools-users" => "{$views}\Tools\Users\index",
    "security-tools-roles" => "{$views}\Tools\Roles\index",
    "security-tools-importer" => "{$views}\Tools\Importer\index",
    //[users]---------------------------------------------------------------------------------------------
    "security-users-create" => "{$views}\Users\Create\index",
    "security-users-list" => "{$views}\Users\List\index",
    "security-users-view" => "{$views}\Users\View\index",
    "security-users-review" => "{$views}\Users\Review\index",
    "security-users-edit" => "{$views}\Users\Edit\index",
    "security-users-delete" => "{$views}\Users\Delete\index",
    //[hierarchies]-----------------------------------------------------------------------------------------------------
    "security-hierarchies-edit" => "{$views}\Hierarchies\Edit\index",
    //[roles]------------------------------------------------------------------------------------------------------------
    "security-roles-create" => "{$views}\Roles\Create\index",
    "security-roles-list" => "{$views}\Roles\List\index",
    "security-roles-view" => "{$views}\Roles\View\index",
    "security-roles-edit" => "{$views}\Roles\Edit\index",
    "security-roles-delete" => "{$views}\Roles\Delete\index",
    //[permissions]-----------------------------------------------------------------------------------------------------
    "security-permissions-list" => "{$views}\Permissions\List\index",
    //[policies]--------------------------------------------------------------------------------------------------------
    "security-policies-edit" => "{$views}\Policies\Edit\index",
    //[loginj]----------------------------------------------------------------------------------------------------------
    "security-login-signin" => "{$views}\Login\Signin\index",
    //[session]---------------------------------------------------------------------------------------------------------
    "security-session-logout" => "{$views}\Session\Logout\index",
    "security-session-signin" => "{$views}\Session\Signin\index",
    "security-session-recovery" => "{$views}\Session\Recovery\index",
    "security-session-resignin" => "{$views}\Session\Resignin\index",
    "security-session-signup" => "{$views}\Session\Signup\index",
    //[settins]---------------------------------------------------------------------------------------------------------
    "security-settings-home" => "{$views}\Settings\Home\index",
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
$assign['left'] = get_security_sidebar();
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