<?php

$strings = service("strings");
$mactivities = model("\App\Modules\Disa\Models\Disa_Activities");
$activity = $mactivities->find($oid);
$description = $strings->get_URLDecode($activity['description']);
$description = $strings->get_Clear($description);


$menu = array(
    array("href" => "/disa/mipg/scores/create/{$oid}", "text" => "Recalificar"),
    array("href" => "#", "text" => "Ayuda")
);


//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "SCORES",
    "log" => "Accedió al listado de <b>calificaciones</b> de la actividad <b>{$description}</b>",
));


$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("class", "mb-3");
$card->assign("header", "Listado de Calificaciones");
//$card->assign("header_menu", $menu);
$card->assign("header_back", "/disa/mipg/activities/list/{$activity["category"]}");
$card->assign("header_add", "/disa/mipg/scores/create/{$oid}");
$card->assign("text", false);
$card->assign("body", view($component . '\table'));
$card->assign("footer", false);
echo($card->view('components/cards/index.tpl'));


?>