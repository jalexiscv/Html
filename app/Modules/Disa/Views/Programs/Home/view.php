<?php

$mprograms = model("App\Modules\Disa\Models\Disa_Programs");


/** Logger **/
history_logger(array(
    "log" => pk(),
    "module" => "DISA",
    "author" => $authentication->get_User(),
    "description" => "Accedió al listado de <b>programas</b>, de la politica <b>{$oid}</b>",
    "code" => "",
));

//$program = $mprograms->find($oid);
//$politic = $program["politic"];

$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("class", "mb-3");
$card->assign("header", "Listado de programas");
$card->assign("header_back", "/disa/mipg/politics/list/{$oid}");
$card->assign("header_add", "/disa/programs/create/{$oid}");
$card->assign("header_help", "#");
$card->assign("text", false);
$card->assign("body", view($component . '\table'));
$card->assign("footer", false);
echo($card->view('components/cards/index.tpl'));


?>