<?php
$prefix = "Transactions.";
$denied = service("smarty");
$denied->assign("title", lang("{$prefix}update-denied-title"));
$denied->assign("message", lang("{$prefix}update-denied-message"));
$denied->assign("permissions", strtoupper($singular));
$denied->assign("continue", "/wallet/transactions/list?time=" . time());
//$denied->assign("voice","Transactions.update-denied-voice");
echo($denied->view('alerts/denied.tpl'));
?>