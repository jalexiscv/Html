<?php

use App\Libraries\Html\HtmlTag;

$mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions", true);

$script = HtmlTag::tag('script');
$script->attr('src', '/themes/assets/libraries/chart/chart.js');
$script->attr('type', 'text/javascript');
$script->content("");
echo($script->render());

$siac = HtmlTag::tag('script');
$siac->attr('src', '/themes/assets/javascripts/Higgs/siac.js');
$siac->attr('type', 'text/javascript');
$siac->content("");
echo($siac->render());

$groups = array();
$dimensions = $mdimensions->get_List();

if (count($dimensions) > 0) {
    foreach ($dimensions as $d) {
        $score = round($mdimensions->get_ScoreByDimension($d["dimension"]), 2);
        /* Opciones */
        $options = array(
            "ver" => array("text" => lang("App.View"), "href" => "/disa/mipg/dimensions/view/{$d["dimension"]}"),
            "edit" => array("text" => lang("App.Edit"), "href" => "/disa/mipg/dimensions/edit/{$d["dimension"]}"),
            "delete" => array("text" => lang("App.Delete"), "href" => "/disa/mipg/dimensions/delete/{$d["dimension"]}"),
            "separator" => array("separator" => true),
            "list" => array("text" => lang("App.List"), "href" => "/disa/mipg/dimensions/home/{$d["dimension"]}"),
        );
        /* Grafico */
        $canvas = HtmlTag::tag('canvas');
        $canvas->attr('id', 'graphic-' . $d["dimension"]);
        $canvas->attr('class', 'p-2');
        $canvas->attr('width', '50');
        $canvas->attr('height', '75');
        $canvas->attr('content', '');

        $js = HtmlTag::tag('script');
        $js->attr('type', 'text/javascript');
        $js->content("heatGraph(\"graphic-{$d["dimension"]}\",\"D{$d["order"]}\",\"{$score}\");");

        $link = HtmlTag::tag('a');
        $link->attr('href', '/disa/mipg/politics/list/' . $d["dimension"]);
        $link->attr('class', 'w-100 btn btn-lg btn-outline-primary');
        $link->content(lang("App.Politics"));

        $dcard = service("smarty");
        $dcard->caching = 0;
        $dcard->set_Mode("bs5x");
        $dcard->assign("type", "dimension");
        $dcard->assign("name", urldecode($d["name"]));
        $dcard->assign("header_menu", $options);
        $dcard->assign("graph", $canvas->render() . $js->render());
        $dcard->assign("link", $link->render());
        $cv = ($dcard->view('components/cards/index.tpl'));

        $col = HtmlTag::tag('div');
        $col->attr('class', 'col');
        $col->content($cv);
        array_push($groups, $col);

    }
    $row = HtmlTag::tag('div');
    $row->attr('class', 'row row-cols-xl-3 g-4');
    $row->content($groups);
    echo($row->render());
} else {
    $card = service("smarty");
    $card->set_Mode("bs5x");
    $card->assign("title", lang("Siac.dimensions-empty-title"));
    $card->assign("message", lang("Siac.dimensions-empty-message"));
    //$card->assign("continue", "/siac/");
    $card->assign("voice", "Disa/dimensions-denied-message.mp3");
    $card->assign("css", "mb-0");
    echo($card->view('alerts/inline/info.tpl'));
}

?>