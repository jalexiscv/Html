<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
$dimension = $mdimensions->where("dimension", $oid)->first();
$dimension_name = urldecode($dimension["name"]);

//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "HOME",
    "log" => "Accedió al listado de <a href=\"/disa/mipg/politics/list/{$oid}\" target==\"_blank\"><b>politicas</b></a>, de la dimensión <b>{$dimension_name}</b> del Módulo MiPG",
));

//echo($row->render());

$body = view("App\Modules\Disa\Views\Mipg\Politics\List\politics");
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("header", "Políticas");
$card->assign("header_back", "/disa/mipg/dimensions/home/" . lpk());
$card->assign("header_add", "/disa/mipg/politics/create/" . $oid);
$card->assign("header_menu", false);
$card->assign("body", $body);
$card->assign("footer", null);
$card->assign("file", __FILE__);
echo($card->view('components/cards/index.tpl'));

?>