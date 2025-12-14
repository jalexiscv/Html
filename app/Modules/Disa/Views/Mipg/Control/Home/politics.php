<?php

use App\Libraries\Bootstrap;

/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
$request = service("request");
$dimension = $request->getGet("dimension");
$b = new Bootstrap();

if (!empty($dimension)) {
    $mpolitics = model('App\Modules\Disa\Models\Disa_Politics');
    $mdimensions = model("\App\Modules\Disa\Models\Disa_Dimensions");
    $dimension = $mdimensions->where("dimension", $dimension)->first();
    $politics = $mpolitics->where("dimension", $dimension["dimension"])->findAll();
    // Texts
    $dimension_name = urldecode($dimension["name"]);

    $html = "";
    $html .= "<table class=\"table table-bordered border-gray\">";
    $html .= "<tr>";
    $html .= "<th class=\"text-center\" style=\"width:36px;\">#</th>";
    $html .= "<th class=\"text-start\">Políticas</th>";
    $html .= "<th class=\"text-center\" style=\"width:90px;\">Puntajes</th>";
    $html .= "<th class=\"text-center\" style=\"width:100px;\">Estado</th>";
    $html .= "<th class=\"text-center\" style=\"width:32px;\"></th>";
    $html .= "<tr>";
    foreach ($politics as $politic) {
        $order = $politic["order"];
        $score = $mpolitics->get_ScoreByPolitic($politic["politic"]);
        $name = urldecode($politic["name"]);
        $html .= "<tr>";
        $html .= "<td class=\"text-center px-2-1\">{$order}</td>";
        $html .= "<td class=\"text-start px-2-1\">{$name}</td>";
        $html .= "<td class=\"text-right px-2\">{$score}</td>";
        $html .= "<td class=\"text-center px-2\">{$b->get_Progress("d-{$politic["politic"]}",array("now"=>$score,"min"=>0, "max"=>100))}</td>";
        $html .= "<td class=\"text-center px-2-1\"><a href=\"/mipg/control/" . lpk() . "?dimension={$dimension["dimension"]}&politic={$politic["politic"]}\"><i class=\"fa fa-eye\"></i></a></td>";
        $html .= "</tr>";
    }

    $html .= "</table>";
    echo($html);
}
?>