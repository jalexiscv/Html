<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("title", lang("Disa.dimensions-denied-title"));
$smarty->assign("message", lang("Disa.dimensions-denied-message"));
$smarty->assign("permissions", $permissions);
$smarty->assign("continue", "/disa/");
$smarty->assign("voice", "Disa/dimensions-denied-message.mp3");
echo($smarty->view('alerts/card/danger.tpl'));
?>
