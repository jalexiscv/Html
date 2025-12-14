<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use App\Libraries\Html\HtmlTag;

$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);
$dimension = $mdimensions->where("dimension", $oid)->first();
$dimension_name = urldecode($dimension["name"]);
//$dimensions = $mdimensions->get_List();

$mpolitics = model("\App\Modules\Disa\Models\Disa_Politics", true);
$politics = $mpolitics->get_ListByDimension($oid);

//echo("<br>Listar politicas de la dimesion: {$oid}");
//echo("<br>Cantidad de politicas: ".count($politics));

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
$regressive = count($politics);

foreach ($politics as $d) {
    $regressive--;

    $options = array(
        "view" => array("text" => lang("App.View"), "href" => "/disa/mipg/politics/view/{$d["politic"]}"),
        "edit" => array("text" => lang("App.Edit"), "href" => "/disa/mipg/politics/edit/{$d["politic"]}"),
        "delete" => array("text" => lang("App.Delete"), "href" => "/disa/mipg/politics/delete/{$d["politic"]}"),
        //"separator" => array("separator" => true),
        //"autodiagnostics" => array("text" => lang("App.Autodiagnostics"), "href" => "/disa/diagnostics/view/{$d["politic"]}"),
    );

    $score = round($mpolitics->get_ScoreByPolitic($d["politic"]), 2);

    $canvas = HtmlTag::tag('canvas');
    $canvas->attr('id', 'graphic-' . $d["politic"]);
    $canvas->attr('class', 'p-2');
    $canvas->attr('width', '50');
    $canvas->attr('height', '75');
    $canvas->attr('content', '');

    $graph = HtmlTag::tag('script');
    $graph->attr('type', 'text/javascript');
    $graph->content("heatGraph(\"graphic-{$d["politic"]}\",\"#{$d["order"]}\",\"{$score}\");");

    $link = HtmlTag::tag('a');
    $link->attr('href', '/disa/mipg/diagnostics/list/' . $d["politic"]);
    $link->attr('class', 'btn btn-outline-primary');
    $link->content(lang("App.Autodiagnostics"));

    $lprograms = HtmlTag::tag('a');
    $lprograms->attr('href', '/disa/programs/home/' . $d["politic"]);
    $lprograms->attr('class', 'btn btn-outline-secondary');
    $lprograms->content(lang("App.Programs"));

    $buttons = HtmlTag::tag('div');
    $buttons->attr('role', 'group');
    $buttons->attr('class', 'btn-group w-100');
    $buttons->content($link->render());

    $smarty = service("smarty");
    $smarty->caching = 0;
    $smarty->set_Mode("bs5x");
    $smarty->assign("type", "normal");
    $smarty->assign("text", urldecode($d["name"]));
    $smarty->assign("header", "Política");
    $smarty->assign("header_menu", $options);
    $smarty->assign("body", $canvas->render() . $graph->render());
    $smarty->assign("footer", $buttons->render());
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


/** Logger **/
history_logger(array(
    "log" => pk(),
    "module" => "DISA",
    "author" => $authentication->get_User(),
    "description" => "El usuario <b>@" . $authentication->get_Alias() . "</b> accedió al listado de <b>politicas</b>, de la dimensión <b>{$dimension_name}</b>",
    "code" => "",
));


echo($row->render());

?>