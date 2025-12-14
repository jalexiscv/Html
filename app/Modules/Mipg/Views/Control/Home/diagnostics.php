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
    $mpolitics = model('App\Modules\Mipg\Models\Mipg_Politics');
    $mdiagnostics = model("\App\Modules\Mipg\Models\Mipg_Diagnostics");
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
        $score = $mdiagnostics->get_Score($diagnostic["diagnostic"]);
        $name = urldecode($diagnostic["name"]);
        $html .= "<tr id=\"diagnostic-{$diagnostic['diagnostic']}\">";
        $html .= "<td class=\"text-center px-2-1 bg-transparent\">{$order}</td>";
        $html .= "<td class=\"text-start px-2-1 bg-transparent\">{$name}</td>";
        $html .= "<td class=\"text-right px-2 bg-transparent\">{$score}</td>";
        $html .= "<td class=\"text-center px-2 bg-transparent\">{$b->get_Progress("d-{$politic["politic"]}",array("now"=>$score,"min"=>0, "max"=>100))}</td>";
        $html .= "<td class=\"text-center px-2-1 bg-transparent\"><a href=\"/mipg/control/home/" . lpk() . "?dimension={$dimension}&politic={$politic["politic"]}&diagnostic={$diagnostic["diagnostic"]}\"><i class=\"fa fa-eye\"></i></a></td>";
        $html .= "</tr>";
    }

    $html .= "</table>";
    echo($html);
}
?>