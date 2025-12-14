<?php


use App\Libraries\Bootstrap;
use Config\Services;

$request = service('request');
$authentication = service('authentication');
$b = new Bootstrap();
/** Models * */
$mdimensions = model("\App\Modules\Mipg\Models\Mipg_Dimensions");

$dimensions = $mdimensions->findAll();

$html = "";
$html .= "<table class=\"table table-bordered border-gray\">";
$html .= "<tr>";
$html .= "<th class=\"text-center\" style=\"width:36px;\">#</th>";
$html .= "<th class=\"text-center\">Dimensiones</th>";
$html .= "<th class=\"text-center\" style=\"width:90px;\">Puntajes</th>";
$html .= "<th class=\"text-center\" style=\"width:100px;\">Estado</th>";
$html .= "<th class=\"text-center\" style=\"width:32px;\"></th>";
$html .= "<tr>";
foreach ($dimensions as $dimension) {
    $order = $dimension["order"];
    $score = $mdimensions->get_Score($dimension["dimension"]);
    $name = urldecode($dimension["name"]);
    $html .= "<tr id=\"dimension-{$dimension["dimension"]}\">";
    $html .= "<td class=\"text-center px-2-1 bg-transparent\">{$order}</td>";
    $html .= "<td class=\"text-start px-2-1 bg-transparent\">{$name}</td>";
    $html .= "<td class=\"text-right px-2 bg-transparent\">{$score}</td>";
    $html .= "<td class=\"text-center px-2 bg-transparent\">{$b->get_Progress("d-{$dimension["dimension"]}",array("now"=>$score,"min"=>0, "max"=>100))}</td>";
    $html .= "<td class=\"text-center px-2-1 bg-transparent\"><a href=\"/mipg/control/home/" . lpk() . "?dimension={$dimension["dimension"]}\"><i class=\"fa fa-eye\"></i></a></td>";
    $html .= "</tr>";
}
$html .= "</table>";
echo($html);
?>