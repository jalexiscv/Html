<?php

/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("type", "normal");
$smarty->assign("header", "Módulo de Redes Sociales");
$smarty->assign("image", "/themes/assets/images/header/networks.png");
$smarty->assign("body", lang("Networks.intro-1"));
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));

?>