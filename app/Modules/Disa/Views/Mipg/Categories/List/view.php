<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
$mpolitics = model("\App\Modules\Disa\Models\Disa_Politics");
$mdiagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics");
$mcomponents = model("\App\Modules\Disa\Models\Disa_Components");
//$mcategories = model("\App\Modules\Disa\Models\Disa_Categories");

$component = $mcomponents->where("component", $oid)->first();
$component_name = urldecode($component["name"]);


//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "CATEGORIES",
    "log" => "Accedió al listado de <b>categorias</b>, del componente <b>{$component_name}</b>",
));


$body = view("App\Modules\Disa\Views\Mipg\Categories\List\categories");
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("header", "Categorias");
$card->assign("header_back", "/disa/mipg/components/list/" . $component["diagnostic"]);
$card->assign("header_add", "/disa/mipg/categories/create/" . $oid);
$card->assign("header_menu", false);
$card->assign("body", $body);
$card->assign("footer", null);
$card->assign("file", __FILE__);
echo($card->view('components/cards/index.tpl'));

?>