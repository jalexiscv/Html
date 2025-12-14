<?php

use App\Libraries\Bootstrap;

//[models]--------------------------------------------------------------------------------------------------------------
$mpolitics = model('App\Modules\Mipg\Models\Mipg_Politics');
$mdimensions = model("\App\Modules\Mipg\Models\Mipg_Dimensions");
//[vars]--------------------------------------------------------------------------------------------------------------
$request = service("request");
$dimension = $request->getGet("dimension");
$b = new Bootstrap();


if (!empty($dimension)) {

    $dimension = $mdimensions->get_Dimension($dimension);


    //echo("Dimensión: {$dimension}");
    //print_r($dimension);
    //exit();


    $politics = $mpolitics->get_Politics($dimension["dimension"]);
    // Texts
    $dimension_name = safe_urldecode($dimension["name"]);

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
        $score = $mpolitics->get_Score($politic["politic"]);
        $name = urldecode($politic["name"]);
        $html .= "<tr id=\"politic-{$politic["politic"]}\">";
        $html .= "<td class=\"text-center px-2-1  bg-transparent\">{$order}</td>";
        $html .= "<td class=\"text-start px-2-1  bg-transparent\">{$name}</td>";
        $html .= "<td class=\"text-right px-2  bg-transparent\">{$score}</td>";
        $html .= "<td class=\"text-center px-2  bg-transparent\">{$b->get_Progress("d-{$politic["politic"]}",array("now"=>$score,"min"=>0, "max"=>100))}</td>";
        $html .= "<td class=\"text-center px-2-1  bg-transparent\"><a href=\"/mipg/control/home/" . lpk() . "?dimension={$dimension["dimension"]}&politic={$politic["politic"]}\"><i class=\"fa fa-eye\"></i></a></td>";
        $html .= "</tr>";
    }

    $html .= "</table>";
    echo($html);
}

?>