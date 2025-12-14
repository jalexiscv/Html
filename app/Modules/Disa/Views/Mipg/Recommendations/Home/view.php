<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

$html = "<div class=\"row  row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1  text-center shortcuts\">";

$options = array(
    array("href" => "/disa/mipg/recommendations/list/2023/" . lpk(), "title" => "Año 2023", "icon" => "far fa-search", "class" => "disabled"),
    array("href" => "/disa/mipg/recommendations/list/2022/" . lpk(), "title" => "Año 2022", "icon" => "far fa-search"),
    array("href" => "/disa/mipg/recommendations/list/2021/" . lpk(), "title" => "Año 2021", "icon" => "far fa-search"),
    array("href" => "/disa/mipg/recommendations/list/2020/" . lpk(), "title" => "Año 2020", "icon" => "far fa-search"),
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