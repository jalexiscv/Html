<?php
/*
 * Copyright (c) 2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$continue = "/c4isr/cases/view/{$oid}";

$smarty->assign("title", lang("Cases.osints-view-forbidden-title"));
$smarty->assign("message", lang("Cases.osints-view-forbidden-message"));
//$smarty->assign("permissions", $permissions);
$smarty->assign("continue", $continue);
$smarty->assign("voice", "c4isr/cases-osints-view-forbidden-message.mp3");
echo($smarty->view('alerts/card/danger.tpl'));

?>