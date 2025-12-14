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
$component = $request->getGet("component");

$b = new Bootstrap();

if (!empty($dimension) && !empty($politic) && !empty($diagnostic) && !empty($component)) {
    $mcomponents = model('App\Modules\Disa\Models\Disa_Components');
    $mcategories = model("\App\Modules\Disa\Models\Disa_Categories");

    $component = $mcomponents->where("component", $component)->first();
    $categories = $mcategories->where("component", $component["component"])->findAll();
    // Texts
    $component_name = urldecode($component["name"]);

    $html = "";
    $html .= "<table class=\"table table-bordered border-gray\">";
    $html .= "<tr>";
    $html .= "<th class=\"text-center \" style=\"width:36px;\">#</th>";
    $html .= "<th class=\"text-start\">Categorias</th>";
    $html .= "<th class=\"text-center\" style=\"width:90px;\">Puntajes</th>";
    $html .= "<th class=\"text-center\" style=\"width:100px;\">Estado</th>";
    $html .= "<th class=\"text-center\" style=\"width:32px;\"></th>";
    $html .= "<tr>";
    foreach ($categories as $category) {
        $order = $category["order"];
        $score = $mcategories->get_ScoreByCategory($category["category"]);
        $name = urldecode($category["name"]);
        $html .= "<tr>";
        $html .= "<td class=\"text-center px-2-1\">{$order}</td>";
        $html .= "<td class=\"text-start px-2-1\">{$name}</td>";
        $html .= "<td class=\"text-right px-2\">{$score}</td>";
        $html .= "<td class=\"text-center px-2\">{$b->get_Progress("d-{$category["category"]}",array("now"=>$score,"min"=>0, "max"=>100))}</td>";
        $html .= "<td class=\"text-center px-2-1\"><a href=\"/mipg/control/" . lpk() . "?dimension={$dimension}&politic={$politic}&diagnostic={$diagnostic}&component={$component["component"]}&category={$category["category"]}\"><i class=\"fa fa-eye\"></i></a></td>";
        $html .= "</tr>";
    }

    $html .= "</table>";
    echo($html);
}
?>