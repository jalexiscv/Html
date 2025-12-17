<?php
session()->set('main_template', null);
session()->set('main', null);
session()->set('right', null);
session()->set('plugin_tables', null);
session()->set('page_template', null);
session()->set('page_message', null);
session()->set('page_trace', null);
//echo lang('Social.shortTime', [time()]);
$src = 'App\Modules\Facebook\Views';
switch ($view) {
    /** Base **/
    case "facebook-home":
        view("{$src}\Home\index");
        break;
    case "facebook-signin":
        view("{$src}\Signin\index");
        break;
    case "facebook-login":
        view("{$src}\Login\index");
        break;
    case "facebook-logout":
        view("{$src}\Logout\index");
        break;
    case "facebook-settings":
        view("{$src}\Settings\index");
        break;
    /** Others **/
    default:
        view("{$src}\E404\index");
        break;
}
/** Smarty **/
$smarty = service("smarty");
/** UI **/
$smarty->assign("page_template", session()->get('page_template'));
$smarty->assign("main_template", session()->get('main_template'));// Determina la variante del template de contenidos principal
$smarty->assign("plugin_tables", session()->get('plugin_tables'));// Indica si se utilizaran tablas en la vista
$smarty->assign("page_trace", session()->get('page_trace'));
/** Datas **/
$smarty->assign("styles", view("App\Modules\Nexus\Views\Styles\index"), true);
$smarty->assign("loggedin", $authentication->get_LoggedIn(), true);
$smarty->assign("user", $authentication->get_Value("user"), true);
$smarty->assign("alias", $authentication->get_Value("alias"), true);
$smarty->assign("avatar", $authentication->get_Value("avatar"), true);
$smarty->assign("host", $authentication->get_Value("host"), true);
$smarty->assign("logo", $authentication->get_ClientLogo("landscape"), true);
$smarty->assign("sidebar", get_facebook_sidebar("/social/"));
//$smarty->assign("sidebar_modules", get_application_sidebar());
$smarty->assign("title", "");
$smarty->assign("description", "");
$smarty->assign("image", "");
$smarty->assign("page_message", session()->get('page_message'));
$smarty->assign("main", session()->get('main'));
$smarty->assign("right", session()->get('right'));
echo($smarty->view('index.tpl'));

?>