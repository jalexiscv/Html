<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use App\Libraries\Html\HtmlTag;


$mdiagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics");
$mpolitics = model("\App\Modules\Disa\Models\Disa_Politics");
$diagnostic = $mdiagnostics->where("diagnostic", $oid)->first();
$politic = $mpolitics->where("politic", $diagnostic["politic"])->first();
$politic_name = urldecode($politic["name"]);

$mcomponents = model("\App\Modules\Disa\Models\Disa_Components");
$components = $mcomponents->get_ListByDiagnostic($oid);

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
$regressive = count($components);

foreach ($components as $d) {
    $regressive--;

    $options = array(
        "edit" => array("text" => lang("App.Edit"), "href" => "/disa/mipg/components/edit/{$d["component"]}"),
        "delete" => array("text" => lang("App.Delete"), "href" => "/disa/mipg/components/delete/{$d["component"]}"),
        //"separator" => array("separator" => true),
        //"autocomponents" => array("text" => lang("App.Autocomponents"), "href" => "/disa/components/view/{$d["diagnostic"]}"),
    );

    $score = round($mcomponents->get_ScoreByComponent($d["component"]), 2);

    $canvas = HtmlTag::tag('canvas');
    $canvas->attr('id', 'graphic-' . $d["component"]);
    $canvas->attr('class', 'p-2');
    $canvas->attr('width', '50');
    $canvas->attr('height', '75');
    $canvas->attr('content', '');

    $graph = HtmlTag::tag('script');
    $graph->attr('type', 'text/javascript');
    $graph->content("heatGraph(\"graphic-{$d["component"]}\",\"#{$d["order"]}\",\"{$score}\");");

    $link = HtmlTag::tag('a');
    $link->attr('href', '/disa/mipg/categories/list/' . $d["component"]);
    $link->attr('class', 'btn btn-outline-primary w100');
    //$link->content(lang("App.Categories"));
    $link->content("Categorías | Descripción");

    $smarty = service("smarty");
    $smarty->caching = 0;
    $smarty->set_Mode("bs5x");
    $smarty->assign("type", "dimension");
    $smarty->assign("text", urldecode($d["name"]));
    $smarty->assign("header", "Componente");
    $smarty->assign("name", urldecode($d["name"]));
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


/**
 * history_logger(array(
 * "log" => pk(),
 * "module" => "DISA",
 * "author" => $authentication->get_User(),
 * "description" => "El usuario <b>@" . $authentication->get_Alias() . "</b> accedió al listado de <b><a href=\"/disa/mipg/components/list/{$oid}\" target=\"_blank\">componentes</a></b> del autodiagnostico de la política <b><a href=\"/disa/mipg/diagnostics/list/{$oid}\" target=\"_blank\">{$politic_name}</a></b>",
 * "code" => "",
 * ));
 * */


echo($row->render());

?>