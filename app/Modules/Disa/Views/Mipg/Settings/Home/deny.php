<?php
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
if ($authentication->get_LoggedIn()) {
    $smarty->assign("title", lang("Social.posts-create-denied-title"));
    $smarty->assign("message", lang("Social.posts-create-denied-message"));
    $smarty->assign("permissions", strtoupper("social-posts-create"));
    $smarty->assign("continue", "/disa/home/" . lpk());
    $smarty->assign("voice", "social-posts-create-denied-message.mp3");
    echo($smarty->view('alerts/card/denied.tpl'));
} else {
    $smarty->assign("title", lang("App.login-required-title"));
    $smarty->assign("message", lang("App.login-required-message"));
    $smarty->assign("continue", "/disa/home/" . lpk());
    $smarty->assign("signin", true);
    $smarty->assign("voice", "app-login-required-message.mp3");
    echo($smarty->view('alerts/card/warning.tpl'));
}
?>