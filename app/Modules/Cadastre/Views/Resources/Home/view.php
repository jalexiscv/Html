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
$chead->assign("image", "/themes/assets/images/header/logo-repositorio-ita.png");
$chead->assign("body", false);
$chead->assign("footer", false);
$html .= $chead->view('components/cards/index.tpl');
$html .= "</div>";
$html .= "</div>";

$html .= "<div class=\"row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1  text-center shortcuts\">";

$options = array(
    array("href" => "/cadastre/resources/list/" . lpk(), "title" => "General", "icon" => "fa-books"),
    array("href" => "#" . lpk(), "title" => "Categorías", "icon" => "fa-layer-group"),
    array("href" => "#" . lpk(), "title" => "Autores", "icon" => "fa-tasks"),
    array("href" => "/cadastre/networks/list/" . lpk(), "title" => "Redes", "icon" => "fa-pennant"),
    array("href" => "#" . lpk(), "title" => "Historial", "icon" => "fa-history"),
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
    $card->assign("body", "<i class=\"icon-primary far {$option["icon"]} fa-4x\"></i>");
    $card->assign("footer", "<a href=\"{$option["href"]}\" class=\"w-100 btn btn-lg btn-outline-primary\">Acceder</a>");
    $html .= $card->view('components/cards/index.tpl');
    $html .= "</div>";
}

$html .= "</div>";
echo($html);
?>