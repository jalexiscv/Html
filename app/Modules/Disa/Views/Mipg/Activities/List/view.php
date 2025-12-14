<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

$dimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
$politics = model("\App\Modules\Disa\Models\Disa_Politics", true);
$diagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics", true);
$components = model("\App\Modules\Disa\Models\Disa_Components", true);
$categories = model("\App\Modules\Disa\Models\Disa_Categories", true);

$category = $categories->find($oid);
$category_name = urldecode($category["name"]);

$menu = array(
    array("href" => "/disa/mipg/activities/create/{$oid}", "text" => "Crear"),
    array("href" => "#", "text" => "Ayuda")
);

$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("class", "mb-3");
$card->assign("header", "Listado de Actividades");
//$card->assign("header_menu", $menu);
$card->assign("header_back", "/disa/mipg/categories/list/{$category["component"]}");
$card->assign("header_add", "/disa/mipg/activities/create/{$oid}");

$card->assign("text", false);
$card->assign("body", view($component . '\table'));
$card->assign("footer", false);


//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "ACTIVITIES",
    "log" => "Accedió al listado de de <b>actividades</b> del la categoría <b><a href=\"/disa/mipg/activities/list/{$oid}\" target=\"_blank\">{$category_name}</a></b>",
));


echo($card->view('components/cards/index.tpl'));


?>