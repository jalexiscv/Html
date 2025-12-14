<?php

$html = "<div class=\"row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1  text-center shortcuts\">";

$options = array(
    array("href" => "/disa/settings/home/" . lpk(), "title" => "Información de la entidad", "icon" => "fa-landmark"),
    array("href" => "/disa/siac/institutionality/home/" . lpk(), "title" => "Adecuación de la intitucionalidad", "icon" => "fa-archive"),
    array("href" => "/disa/institutional/home/" . lpk(), "title" => "Planes institucionales", "icon" => "fa-books"),
    array("href" => "/disa/siac/dimensions/home/" . lpk(), "title" => "Dimensiones MiPG", "icon" => "fa-layer-group"),
    array("href" => "/disa/siac/control/" . lpk(), "title" => "Cuadro de control", "icon" => "fa-tasks"),
    array("href" => "/disa/siac/recommendations/home/" . lpk(), "title" => "Captura de recomendaciones", "icon" => "fa-pennant"),
    array("href" => "/disa/history/" . lpk(), "title" => "Historial", "icon" => "fa-history"),
);

foreach ($options as $option) {
    $html .= "<div class=\"col mb-3\">";
    $card = service("smarty");
    $card->set_Mode("bs5x");
    $card->caching = 0;
    $card->assign("type", "normal");
    $card->assign("class", "mb-3");
    $card->assign("header", $option["title"]);
    $card->assign("header_back", false);
    $card->assign("body", "<i class=\"far {$option["icon"]} fa-4x\"></i>");
    $card->assign("footer", "<a href=\"{$option["href"]}\" class=\"w-100 btn btn-lg btn-orange\">Acceder</a>");
    $html .= $card->view('components/cards/index.tpl');
    $html .= "</div>";
}

$html .= "</div>";
echo($html);
?>