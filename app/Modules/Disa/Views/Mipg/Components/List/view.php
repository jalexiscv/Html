<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
$s = service('strings');
$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
$mpolitics = model("\App\Modules\Disa\Models\Disa_Politics", true);
$mdiagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);

$diagnostic = $mdiagnostics->where("diagnostic", $oid)->first();
$diagnostic_name = $s->get_URLDecode(@$diagnostic["name"]);


//echo($row->render());

//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "DIMENSIONS",
    "log" => "Accedió al listado de <b>componentes</b>, del diganostico <b>{$diagnostic_name}</b>",
));


$body = view("App\Modules\Disa\Views\Mipg\Components\List\components");
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("header", "Componentes | Indices desagregados");
$card->assign("header_back", "/disa/mipg/diagnostics/list/{$diagnostic["politic"]}?option=politic");
$card->assign("header_add", "/disa/mipg/components/create/" . $oid);
$card->assign("header_menu", false);
$card->assign("body", $body);
$card->assign("footer", null);
$card->assign("file", __FILE__);
echo($card->view('components/cards/index.tpl'));

?>