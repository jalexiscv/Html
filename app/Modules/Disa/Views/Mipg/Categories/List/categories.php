<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use App\Libraries\Html\HtmlTag;

$mcomponents = model("\App\Modules\Disa\Models\Disa_Components");
$mcategories = model("\App\Modules\Disa\Models\Disa_Categories");
$categories = $mcategories->get_ListByComponent($oid);
$component = $mcomponents->where("component", $oid)->first();
$component_name = urldecode($component["name"]);

$chart = HtmlTag::tag('script');
$chart->attr('src', '/themes/assets/libraries/chart/chart.js');
$chart->attr('type', 'text/javascript');
$chart->content("");
echo($chart->render());

$disa = HtmlTag::tag('script');
$disa->attr('src', '/themes/assets/javascripts/Higgs/disa.js');
$disa->attr('type', 'text/javascript');
$disa->content("");
echo($disa->render());
$groups = array();
$group = array();
$count = 0;
$regressive = count($categories);
foreach ($categories as $d) {
    $regressive--;
    $options = array(
        "edit" => array("text" => lang("App.Edit"), "href" => "/disa/mipg/categories/edit/{$d["category"]}"),
        "delete" => array("text" => lang("App.Delete"), "href" => "/disa/mipg/categories/delete/{$d["category"]}"),
        //"separator" => array("separator" => true),
        //"autocategories" => array("text" => lang("App.Autocategories"), "href" => "/disa/categories/view/{$d["diagnostic"]}"),
    );
    $score = round($mcategories->get_ScoreByCategory($d["category"]), 2);
    $canvas = HtmlTag::tag('canvas');
    $canvas->attr('id', 'graphic-' . $d["category"]);
    $canvas->attr('class', 'p-2');
    $canvas->attr('width', '50');
    $canvas->attr('height', '75');
    $canvas->attr('content', '');

    $graph = HtmlTag::tag('script');
    $graph->attr('type', 'text/javascript');
    $graph->content("heatGraph(\"graphic-{$d["category"]}\",\"#{$d["category"]}\",\"{$score}\");");

    $link = HtmlTag::tag('a');
    $link->attr('href', '/disa/mipg/activities/list/' . $d["category"]);
    $link->attr('class', 'btn btn-primary');
    $link->content(lang("App.Activities"));

    $smarty = service("smarty");
    $smarty->caching = 0;
    $smarty->set_Mode("bs5x");
    $smarty->assign("type", "dimension");
    $smarty->assign("name", urldecode($d["name"]));
    $smarty->assign("header", "Categorias");
    $smarty->assign("header_menu", $options);
    $smarty->assign("graph", $canvas->render() . $graph->render());
    $smarty->assign("link", $link->render());
    $smarty->assign("class", "h-100");
    $smarty->assign("file", __FILE__);

    $card = ($smarty->view('components/cards/index.tpl'));

    $col = HtmlTag::tag('div');
    $col->attr('class', 'col');
    $col->content($card);

    array_push($groups, $col);
}
$row = HtmlTag::tag('div');
$row->attr('class', 'row row-cols-xxl-3 row-cols-xl-2 g-3 w-100');
$row->content($groups);

echo($row->render());
?>