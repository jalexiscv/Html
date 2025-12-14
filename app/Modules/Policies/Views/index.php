<?php
session()->set('main_template', null);
session()->set('main', null);
session()->set('right', null);
session()->set('plugin_tables', null);
session()->set('page_id', uniqid());
session()->set('page_header', null);
session()->set('page_template', null);
session()->set('page_message', null);
session()->set('page_trace', null);
//echo lang('Social.shortTime', [time()]);
$src = 'App\Modules\Policies\Views';
switch ($view) {
    case "acredit-home":
        view("{$src}\Home\index");
        break;
    case "acredit-applicants-types-list":
        view("{$src}\Applicants\Types\List\index");
        break;
    case "acredit-applicants-types-create":
        view("{$src}\Applicants\Types\Create\index");
        break;
    case "acredit-applicants-types-edit":
        view("{$src}\Applicants\Types\Edit\index");
        break;
    case "acredit-applicants-types-delete":
        view("{$src}\Applicants\Types\Delete\index");
        break;
    /** Conditions **/
    case "policies-conditions-home":
        view("{$src}\Conditions\Home\index");
        break;
    /** Privacy **/
    case "policies-privacy-home":
        view("{$src}\Privacy\Home\index");
        break;
    /** Advertising **/
    case "policies-advertising-home":
        view("{$src}\Advertising\Home\index");
        break;
    /** Cookies **/
    case "policies-cookies-home":
        view("{$src}\Cookies\Home\index");
        break;
    /** Default **/
    default:
        view("{$src}\E404\index");
        break;
}

/* Smarty */
$smarty = service("smarty");
/* ui */
$smarty->assign("page_id", session()->get('page_id'));
$smarty->assign("page_template", session()->get('page_template'));
$smarty->assign("main_template", session()->get('main_template'));// Determina la variante del template de contenidos principal
$smarty->assign("plugin_tables", session()->get('plugin_tables'));// Indica si se utilizaran tablas en la vista
$smarty->assign("page_trace", session()->get('page_trace'));
$smarty->assign("csrf_token", $authentication->csrf_token());
$smarty->assign("csrf_hash", $authentication->csrf_hash());
/* datas */
$smarty->assign("title", DOMAIN);
$smarty->assign("description", "Sistema de Analisis de Oferta Crediticia");
$smarty->assign("image", "");
$smarty->assign("styles", view("App\Modules\Nexus\Views\Styles\index"), true);
$smarty->assign("loggedin", $authentication->get_LoggedIn(), true);
$smarty->assign("user", $authentication->get_Value("user"), true);
$smarty->assign("alias", $authentication->get_Value("alias"), true);
$smarty->assign("avatar", $authentication->get_Value("avatar"), true);
$smarty->assign("host", $authentication->get_Value("host"), true);
$smarty->assign("logo", $authentication->get_ClientLogo("landscape"), true);
$smarty->assign("sidebar", get_acredit_sidebar("/social/"));
$smarty->assign("sidebar_modules", get_application_sidebar());
$smarty->assign("page_header", session()->get('page_header'));
$smarty->assign("page_message", session()->get('page_message'));
$smarty->assign("main", session()->get('main'));
$smarty->assign("right", session()->get('right') . get_application_copyright());
echo($smarty->view('index.tpl'));

?>