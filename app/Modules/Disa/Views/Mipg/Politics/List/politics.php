<?php

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

$siac = HtmlTag::tag('script');
$siac->attr('src', '/themes/assets/javascripts/Higgs/siac.js');
$siac->attr('type', 'text/javascript');
$siac->content("");
echo($siac->render());

$groups = array();
$group = array();
$count = 0;
$regressive = count($politics);

if (count($politics) > 0) {
    foreach ($politics as $d) {
        $regressive--;

        $options = array(
            "view" => array("text" => lang("App.View"), "href" => "/disa/mipg/politics/view/{$d["politic"]}"),
            "edit" => array("text" => lang("App.Edit"), "href" => "/disa/mipg/politics/edit/{$d["politic"]}"),
            "delete" => array("text" => lang("App.Delete"), "href" => "/disa/mipg/politics/delete/{$d["politic"]}"),
            //"separator" => array("separator" => true),
            //"autodiagnostics" => array("text" => lang("App.Autodiagnostics"), "href" => "/siac/diagnostics/view/{$d["politic"]}"),
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


        if (isset($d["programs"]) && $d["programs"] == "Y") {
            $link = HtmlTag::tag('a');
            $link->attr('href', '/disa/mipg/programs/home/' . $d["politic"]);
            $link->attr('class', 'btn btn-outline-secondary');
            $link->content(lang("App.Programs"));
        } else {
            $link = HtmlTag::tag('a');
            $link->attr('href', '/disa/mipg/diagnostics/list/' . $d["politic"] . "/?option=politic");
            $link->attr('class', 'btn btn-outline-primary');
            //$link->content(lang("App.Autodiagnostics"));
            $link->content("Autodiagnosticos <br> Indices desagregados");
        }

        $buttons = HtmlTag::tag('div');
        $buttons->attr('role', 'group');
        $buttons->attr('class', 'btn-group w-100');
        $buttons->content($link->render());

        $dcard = service("smarty");
        $dcard->caching = 0;
        $dcard->set_Mode("bs5x");
        $dcard->assign("type", "dimension");
        $dcard->assign("name", urldecode($d["name"]));
        $dcard->assign("header_menu", $options);
        $dcard->assign("graph", $canvas->render() . $graph->render());
        $dcard->assign("link", $buttons->render());
        $cv = ($dcard->view('components/cards/index.tpl'));

        $col = HtmlTag::tag('div');
        $col->attr('class', 'col');
        $col->content($cv);

        array_push($groups, $col);
    }
    $row = HtmlTag::tag('div');
    $row->attr('class', 'row row-cols-xxl-3 row-cols-xl-2 g-3 w-100');
    $row->content($groups);
    echo($row->render());
} else {
    $card = service("smarty");
    $card->set_Mode("bs5x");
    $card->assign("title", lang("Disa.politics-empty-title"));
    $card->assign("message", sprintf(lang("Disa.politics-empty-message"), $dimension_name));
    //$card->assign("continue", "/siac/");
    $card->assign("voice", "Disa/dimensions-denied-message.mp3");
    $card->assign("css", "mb-0");
    echo($card->view('alerts/inline/info.tpl'));
}

?>