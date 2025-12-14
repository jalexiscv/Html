<?php

/* Smarty */
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->caching = 0;
$smarty->assign("prefix", $prefix);
$main = ($smarty->view('alerts/404.tpl'));

session()->set('page_template', 'page');
session()->set('main_template', 'c9c3');
session()->set('main', $main);
session()->set('right', '');

?>