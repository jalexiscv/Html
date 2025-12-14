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
$mactivities = model("App\Modules\Disa\Models\Disa_Activities");

$plan = $mplans->find($oid);
$activity = $mactivities->find($plan["activity"]);
$category = $activity["category"];


//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "PLAN",
    "log" => "Accedió al  <b>plan de acción</b> <b>{$plan['order']}</b>",
));


$menu = array(
    //array("href"=>"/disa/mipg/activities/create/{$oid}","text"=>"Crear"),
    array("href" => "#", "text" => "Ayuda")
);

$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("class", "mb-3");
$card->assign("header", "Plan de acción " . $string->get_ZeroFill($plan["order"], 4));
//$card->assign("header_menu", $menu);
$card->assign("header_back", "/disa/mipg/activities/list/{$category}");
$card->assign("header_edit", "/disa/mipg/plans/edit/{$plan["plan"]}");
$card->assign("header_delete", "/disa/mipg/plans/delete/{$plan["plan"]}");
$card->assign("header_info", "https://www.linkedin.com/pulse/qu%25C3%25A9-es-un-plan-de-acci%25C3%25B3n-jose-alexis-correa-valencia");
$card->assign("text", false);
$card->assign("body", view($component . '\card'));
$card->assign("footer", false);
echo($card->view('components/cards/index.tpl'));

$cStatus = service("smarty");
$cStatus->set_Mode("bs5x");
$cStatus->caching = 0;
$cStatus->assign("header_back", false);
$cStatus->assign("header_edit", false);
$cStatus->assign("header_delete", false);
$cStatus->assign("header_info", false);
$cStatus->assign("type", "normal");
$cStatus->assign("class", "mb-3");
$cStatus->assign("header", "Estado");
$cStatus->assign("body", view("App\Modules\Disa\Views\Mipg\Plans\Statuses\View\status.php"));
$cStatus->assign("footer", false);
echo($cStatus->view('components/cards/index.tpl'));

?>