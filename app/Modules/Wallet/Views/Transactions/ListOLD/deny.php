<?php
$smarty = service("smarty");
$smarty->assign("title", lang("App.Access-denied-title"));
$smarty->assign("message", lang("App.Access-denied-message"));
$smarty->assign("permissions", strtoupper($plural));
$smarty->assign("continue", "/wallet/transactions/list?time=" . time());
echo($smarty->view('alerts/denied.tpl'));
?>