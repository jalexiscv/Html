<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

/* Smarty */
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->caching = 0;
$smarty->assign("title", "Acceso denegado!");
$smarty->assign("message", "Modulo no contratado!");
$smarty->assign("permissions", false);
$smarty->assign("continue", "/");
$main = ($smarty->view('alerts/card/danger.tpl'));

session()->set('page_template', 'page');
session()->set('main_template', 'c9c3');
session()->set('main', $main);
session()->set('right', '');

?>