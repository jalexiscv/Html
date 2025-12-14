<?php
$prefix = "Wallet.Currencies-delete-";
$reference = $id;
$confirm = service("smarty");
$confirm->assign("icon", "fad fa-recycle");
$confirm->assign("title", sprintf(lang("{$prefix}title"), $id));
$confirm->assign("message", sprintf(lang("{$prefix}message"), $reference));
$confirm->assign("cancel", safe_strtolower("/{$module}/{$component}/list/"));
$confirm->assign("value", $id);
$confirm->assign("submit", lang("App.Delete"));
$confirm->assign("voice", "{$module}-{$component}-delete-voice.mp3");
echo($confirm->view('alerts/confirm.tpl'));
