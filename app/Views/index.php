<?php
helper("Application");
helper('form');
$this->main_template = null;
$this->main = null;
$this->right = null;
$this->plugin_tables = false;
$this->page_template = null;
$this->page_message = null;
$this->page_trace = null;

switch ($view) {
    case "signin":
        view("App\Views\Signin\index");
        break;
    case "facebook":
        view("App\Views\Facebook\index");
        break;
    default:
        view("App\Views\Home\index");
        break;
}

/* Smarty */
$smarty = service("smarty");
/* ui */
$smarty->assign("page_template", $this->page_template);
$smarty->assign("main_template", $this->main_template);// Determina la variante del template de contenidos principal
$smarty->assign("plugin_tables", $this->plugin_tables);// Indica si se utilizaran tablas en la vista
$smarty->assign("page_trace", $this->page_trace);
/* datas */
$smarty->assign("styles", view("App\Modules\Nexus\Views\Styles\index"), true);

$smarty->assign("csrf_token", $authentication->csrf_token(), true);
$smarty->assign("csrf_hash", $authentication->csrf_hash(), true);
$smarty->assign("loggedin", $authentication->get_LoggedIn(), true);
$smarty->assign("user", $authentication->get_Value("user"), true);
$smarty->assign("alias", $authentication->get_Value("alias"), true);
$smarty->assign("avatar", $authentication->get_Value("avatar"), true);
$smarty->assign("host", $authentication->get_Value("host"), true);
$smarty->assign("logo", $authentication->get_ClientLogo("landscape"), true);
$smarty->assign("sidebar", get_application_sidebar("/social/"));
$smarty->assign("page_message", $this->page_message);
//$smarty->assign("sidebar_modules", get_application_sidebar());

$smarty->assign("title", "");
$smarty->assign("description", "");
$smarty->assign("image", "");

$smarty->assign("main", $this->main);
$smarty->assign("right", $this->right);
echo($smarty->view('index.tpl'));

?>