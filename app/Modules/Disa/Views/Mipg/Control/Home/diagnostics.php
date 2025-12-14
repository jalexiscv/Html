<?php

use App\Libraries\Bootstrap;

/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
$request = service("request");
$dimension = $request->getGet("dimension");
$politic = $request->getGet("politic");

$b = new Bootstrap();

if (!empty($dimension) && !empty($politic)) {
    $mpolitics = model('App\Modules\Disa\Models\Disa_Politics');
    $mdiagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics");
    $politic = $mpolitics->where("politic", $politic)->first();
    $diagnostics = $mdiagnostics->where("politic", $politic["politic"])->findAll();
    // Texts
    $politic_name = urldecode($politic["name"]);

    $html = "";
    $html .= "<table class=\"table table-bordered border-gray\">";
    $html .= "<tr>";
    $html .= "<th class=\"text-center \" style=\"width:36px;\">#</th>";
    $html .= "<th class=\"text-start\">Autodiagnosticos</th>";
    $html .= "<th class=\"text-center\" style=\"width:90px;\">Puntajes</th>";
    $html .= "<th class=\"text-center\" style=\"width:100px;\">Estado</th>";
    $html .= "<th class=\"text-center\" style=\"width:32px;\"></th>";
    $html .= "<tr>";
    foreach ($diagnostics as $diagnostic) {
        $order = $diagnostic["order"];
        $score = $mdiagnostics->get_ScoreByDiagnostic($diagnostic["diagnostic"]);
        $name = urldecode($diagnostic["name"]);
        $html .= "<tr>";
        $html .= "<td class=\"text-center px-2-1\">{$order}</td>";
        $html .= "<td class=\"text-start px-2-1\">{$name}</td>";
        $html .= "<td class=\"text-right px-2\">{$score}</td>";
        $html .= "<td class=\"text-center px-2\">{$b->get_Progress("d-{$politic["politic"]}",array("now"=>$score,"min"=>0, "max"=>100))}</td>";
        $html .= "<td class=\"text-center px-2-1\"><a href=\"/mipg/control/" . lpk() . "?dimension={$dimension}&politic={$politic["politic"]}&diagnostic={$diagnostic["diagnostic"]}\"><i class=\"fa fa-eye\"></i></a></td>";
        $html .= "</tr>";
    }

    $html .= "</table>";
    echo($html);
}
?>