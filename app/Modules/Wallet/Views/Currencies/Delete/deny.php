<?php
$smarty = service("smarty");
$smarty->assign("title", lang("App.Access-denied-title"));
$smarty->assign("message", lang("App.Access-denied-message"));
$smarty->assign("permissions", strtoupper($singular));
$smarty->assign("continue", "/wallet/currencies/");
echo($smarty->view('alerts/denied.tpl'));
?>