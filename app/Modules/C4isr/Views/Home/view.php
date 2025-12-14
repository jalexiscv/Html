<?php

/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", "Módulo de C4ISR");
$smarty->assign("image", "/themes/assets/images/header/logoc4isr.png?v3");
$smarty->assign("body", lang("C4isr.intro-general"));
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));

$sinfo = service("smarty");
$sinfo->set_Mode("bs5x");
$sinfo->caching = 0;
$sinfo->assign("title", lang("C4isr.home-note"));
$sinfo->assign("message", lang("C4isr.home-info"));
echo($sinfo->view('alerts/inline/info.tpl'));
//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "C4ISR",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "HOME",
    "log" => "El usuario accede a la vista principal del Módulo C4ISR",
));

?>