<?php
/*
 * Copyright (c) 2022-2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

$string = service("strings");
$mplans = model("App\Modules\Disa\Models\Disa_Plans");
$plan = $mplans->find($oid);

$menu = array(
    //array("href"=>"/disa/mipg/plans/view/{$oid}","text"=>"<i class=\"fas fa-chevron-left\"></i> Atras"),
    array("href" => "#", "text" => "Ayuda")
);

//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "PLAN",
    "log" => "Accedió a los <b>detalles</b> de  <b>plan de acción</b> <b>{$plan['order']}</b>",
));

$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("class", "mb-3");
$card->assign("header", "Detalles de plan de acción " . $string->get_ZeroFill($plan["order"], 4));
$card->assign("header_menu", $menu);
$card->assign("header_back", "/disa/mipg/plans/view/{$oid}");
$card->assign("text", false);
$card->assign("body", view($component . '\card'));
$card->assign("footer", false);
echo($card->view('components/cards/index.tpl'));


?>