<?php
$html = "<div class=\"row\">";
$html .= "<div class=\"col-12\">";
$chead = service("smarty");
$chead->set_Mode("bs5x");
$chead->caching = 0;
$chead->assign("type", "normal");
$chead->assign("class", "mb-3");
$chead->assign("header", false);
$chead->assign("header_back", false);
$chead->assign("image", "/themes/assets/images/header/mipg.png");
$chead->assign("body", false);
$chead->assign("footer", false);
$html .= $chead->view('components/cards/index.tpl');
$html .= "</div>";
$html .= "</div>";

$html .= "<div class=\"row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1  text-center shortcuts\">";

$options = array(
    array("href" => "/disa/settings/home/" . lpk(), "title" => "Información de la entidad", "icon" => "fa-landmark"),
    array("href" => "/disa/mipg/institutionality/home/" . lpk(), "title" => "Institucionalidad", "icon" => "fa-archive"),
    array("href" => "/disa/institutional/home/" . lpk(), "title" => "Planes institucionales", "icon" => "fa-books"),
    array("href" => "/disa/mipg/dimensions/home/" . lpk(), "title" => "Dimensiones MiPG", "icon" => "fa-layer-group"),
    array("href" => "/disa/mipg/control/" . lpk(), "title" => "Cuadro de control", "icon" => "fa-tasks"),
    array("href" => "/disa/mipg/recommendations/home/" . lpk(), "title" => "Recomendaciones", "icon" => "fa-pennant"),
    array("href" => "/history/home/" . lpk(), "title" => "Historial", "icon" => "fa-history"),
);

foreach ($options as $option) {
    $html .= "<div class=\"col mb-3\">";
    $card = service("smarty");
    $card->set_Mode("bs5x");
    $card->caching = 0;
    $card->assign("type", "normal");
    $card->assign("class", "mb-3");
    $card->assign("header", $option["title"]);
    $card->assign("title_class", "   ");
    $card->assign("header_back", false);
    $card->assign("image", false);
    $card->assign("body", "<i class=\"icon-orange far {$option["icon"]} fa-4x\"></i>");
    $card->assign("footer", "<a href=\"{$option["href"]}\" class=\"w-100 btn btn-lg btn-outline-orange\">Acceder</a>");
    $html .= $card->view('components/cards/index.tpl');
    $html .= "</div>";
}

$html .= "</div>";
echo($html);
//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "HOME",
    "log" => "El usuario accede a la <a href=\"/disa/home/{$oid}\" target==\"_blank\">vista principal<a> del Módulo MiPG",
));
?>