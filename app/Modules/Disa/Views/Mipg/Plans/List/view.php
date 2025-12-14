<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

$mactivities = model("\App\Modules\Disa\Models\Disa_Activities");
$activity = $mactivities->find($oid);
$category = $activity["category"];

$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("class", "mb-3");
$card->assign("header", "Listado de planes de acción");
$card->assign("header_back", "/disa/mipg/activities/list/{$category}");
$card->assign("header_add", "/disa/mipg/plans/create/{$oid}");
$card->assign("header_help", "#");
$card->assign("text", false);
$card->assign("body", view($component . '\table'));
$card->assign("footer", false);
echo($card->view('components/cards/index.tpl'));


?>