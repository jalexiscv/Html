<?php

use App\Libraries\Html\HtmlTag;

$body = view("App\Modules\Disa\Views\Mipg\Dimensions\Home\dimensions");
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("header", lang("Mipg.dimensions-title"));
$card->assign("header_back", "/disa/home/" . lpk());
$card->assign("header_add", "/disa/mipg/dimensions/create/" . lpk());
$card->assign("header_menu", false);
$card->assign("body", $body);
$card->assign("footer", null);
$card->assign("file", __FILE__);
echo($card->view('components/cards/index.tpl'));

?>