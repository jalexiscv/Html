<?php
$prefix = "Wallet.Currencies-";
$denied = service("smarty");
$denied->assign("title", lang("{$prefix}update-denied-title"));
$denied->assign("message", lang("{$prefix}update-denied-message"));
$denied->assign("permissions", strtoupper($singular));
$denied->assign("continue", "/wallet/currencies/list?time=" . time());
$denied->assign("voice", "wallet-currencies-update-denied-voice.mp3");
echo($denied->view('alerts/denied.tpl'));
?>