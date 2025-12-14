<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use App\Libraries\Html\HtmlTag;

$mpolitics = model("\App\Modules\Disa\Models\Disa_Politics");
$politic = $mpolitics->where("politic", $oid)->first();
$politic_name = urldecode($politic["name"]);

$mdiagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics");
$diagnostics = $mdiagnostics->get_ListByPolitic($oid);


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
$regressive = count($diagnostics);

foreach ($diagnostics as $d) {
    $regressive--;

    $options = array(
        "edit" => array("text" => lang("App.Edit"), "href" => "/disa/mipg/diagnostics/edit/{$d["diagnostic"]}"),
        "delete" => array("text" => lang("App.Delete"), "href" => "/disa/mipg/diagnostics/delete/{$d["diagnostic"]}"),
        //"separator" => array("separator" => true),
        //"autodiagnostics" => array("text" => lang("App.Autodiagnostics"), "href" => "/disa/diagnostics/view/{$d["diagnostic"]}"),
    );

    $score = round($mdiagnostics->get_ScoreBydiagnostic($d["diagnostic"]), 2);

    $canvas = HtmlTag::tag('canvas');
    $canvas->attr('id', 'graphic-' . $d["diagnostic"]);
    $canvas->attr('class', 'p-2');
    $canvas->attr('width', '50');
    $canvas->attr('height', '75');
    $canvas->attr('content', '');

    $graph = HtmlTag::tag('script');
    $graph->attr('type', 'text/javascript');
    $graph->content("heatGraph(\"graphic-{$d["diagnostic"]}\",\"v {$d["version"]}\",\"{$score}\");");

    $link = HtmlTag::tag('a');
    $link->attr('href', '/disa/mipg/components/list/' . $d["diagnostic"]);
    $link->attr('class', 'btn btn-outline-primary w100');
    //$link->content(lang("App.Components"));
    $link->content("Componentes <br> Indices desagregados");

    $smarty = service("smarty");
    $smarty->caching = 0;
    $smarty->set_Mode("bs5x");
    $smarty->assign("type", "normal");
    $smarty->assign("text", urldecode($d["name"]));
    $smarty->assign("header", urldecode($d["name"]));
    $smarty->assign("header_menu", $options);
    $smarty->assign("body", $canvas->render() . $graph->render());
    $smarty->assign("footer", $link->render());
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

//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "HOME",
    "log" => "Accedió al listado de <a href=\"/disa/mipg/diagnostics/list/{$oid}?option=politic\" target==\"_blank\"><b>autodiagnosticos</b></a>, de la política <b>{$politic_name}</b>.",
));

echo($row->render());

?>