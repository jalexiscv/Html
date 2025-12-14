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
$diagnostic = $request->getGet("diagnostic");

$b = new Bootstrap();

if (!empty($dimension) && !empty($politic) && !empty($diagnostic)) {
    $mdiagnostics = model("\App\Modules\Disa\Models\Disa_Diagnostics");
    $mcomponents = model('App\Modules\Disa\Models\Disa_Components');

    $diagnostic = $mdiagnostics->where("diagnostic", $diagnostic)->first();
    $components = $mcomponents->where("diagnostic", $diagnostic["diagnostic"])->findAll();
    // Texts
    $diagnostic_name = urldecode($diagnostic["name"]);

    $html = "";
    $html .= "<table class=\"table table-bordered border-gray\">";
    $html .= "<tr>";
    $html .= "<th class=\"text-center \" style=\"width:36px;\">#</th>";
    $html .= "<th class=\"text-start\">Componentes</th>";
    $html .= "<th class=\"text-center\" style=\"width:90px;\">Puntajes</th>";
    $html .= "<th class=\"text-center\" style=\"width:100px;\">Estado</th>";
    $html .= "<th class=\"text-center\" style=\"width:32px;\"></th>";
    $html .= "<tr>";
    foreach ($components as $component) {
        $order = $component["order"];
        $score = $mcomponents->get_ScoreByComponent($component["component"]);
        $name = urldecode($component["name"]);
        $html .= "<tr>";
        $html .= "<td class=\"text-center px-2-1\">{$order}</td>";
        $html .= "<td class=\"text-start px-2-1\">{$name}</td>";
        $html .= "<td class=\"text-right px-2\">{$score}</td>";
        $html .= "<td class=\"text-center px-2\">{$b->get_Progress("d-{$component["component"]}",array("now"=>$score,"min"=>0, "max"=>100))}</td>";
        $html .= "<td class=\"text-center px-2-1\"><a href=\"/mipg/control/" . lpk() . "?dimension={$dimension}&politic={$politic}&diagnostic={$diagnostic["diagnostic"]}&component={$component["component"]}\"><i class=\"fa fa-eye\"></i></a></td>";
        $html .= "</tr>";
    }

    $html .= "</table>";
    echo($html);
}
?>