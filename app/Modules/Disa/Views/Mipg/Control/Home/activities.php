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
$category = $request->getGet("category");

$b = new Bootstrap();

if (!empty($dimension) && !empty($politic) && !empty($diagnostic) && !empty($component) && !empty($category)) {
    $mcategories = model("\App\Modules\Disa\Models\Disa_Categories");
    $mactivities = model("\App\Modules\Disa\Models\Disa_Activities");

    $category = $mcategories->where("category", $category)->first();
    $activities = $mactivities->where("category", $category["category"])->findAll();
    // Texts
    $category_name = urldecode($category["name"]);

    $html = "";
    $html .= "<table class=\"table table-bordered border-gray\">";
    $html .= "<tr>";
    $html .= "<th class=\"text-center \" style=\"width:36px;\">#</th>";
    $html .= "<th class=\"text-start\">Actividades</th>";
    $html .= "<th class=\"text-center\" style=\"width:90px;\">Puntajes</th>";
    $html .= "<th class=\"text-center\" style=\"width:100px;\">Estado</th>";
    $html .= "<th class=\"text-center\" style=\"width:32px;\"></th>";
    $html .= "<tr>";
    foreach ($activities as $activity) {
        $order = $activity["order"];
        $score = $mactivities->get_Score($activity["activity"]);
        $name = urldecode($activity["description"]);
        $html .= "<tr>";
        $html .= "<td class=\"text-center px-2-1\">{$order}</td>";
        $html .= "<td class=\"text-start px-2-1\">{$name}</td>";
        $html .= "<td class=\"text-right px-2\">{$score}</td>";
        $html .= "<td class=\"text-center px-2\">{$b->get_Progress("d-{$activity["activity"]}",array("now"=>$score,"min"=>0, "max"=>100))}</td>";
        $html .= "<td class=\"text-center px-2-1\"><a href=\"/mipg/control/" . lpk() . "?dimension={$dimension}&politic={$politic}&diagnostic={$diagnostic}&component={$component}&category={$category["category"]}&activity={$activity["activity"]}\"><i class=\"fa fa-eye\"></i></a></td>";
        $html .= "</tr>";
    }

    $html .= "</table>";
    echo($html);
}
?>