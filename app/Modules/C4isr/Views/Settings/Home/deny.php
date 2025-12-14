<?php
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$continue = "/c4isr";
if ($authentication->get_LoggedIn()) {
    $smarty->assign("title", lang("C4isr.settings-home-denied-title"));
    $smarty->assign("message", lang("C4isr.settings-home-denied-message"));
    $smarty->assign("permissions", $permissions);
    $smarty->assign("continue", $continue);
    $smarty->assign("voice", "c4isr/breaches-list-denied-message.mp3");
    echo($smarty->view('alerts/card/danger.tpl'));
} else {
    $smarty->assign("title", lang("App.login-required-title"));
    $smarty->assign("message", lang("App.login-required-message"));
    $smarty->assign("continue", $continue);
    $smarty->assign("signin", true);
    $smarty->assign("voice", "app-login-required-message.mp3");
    echo($smarty->view('alerts/card/warning.tpl'));
}
?>