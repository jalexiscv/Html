<?php

use App\Libraries\Bootstrap;
use App\Libraries\Grid;

use App\Libraries\Strings;

$authentication = service('authentication');
$strings = new Strings();

$mplans = model("App\Modules\Disa\Models\Disa_Plans");
$mcauses = model("App\Modules\Disa\Models\Disa_Causes");

$plan = $mplans->find($oid);
$description = $strings->get_Striptags(urldecode($plan["description"]));

$warning = service("smarty");
$warning->set_Mode("bs5x");
$warning->caching = 0;
$warning->assign("title", "Causa a analizar");
$warning->assign("message", "{$description}");
$body = ($warning->view('alerts/inline/warning.tpl'));

$body .= "<table class=\"table table-striped\">";
$body .= "<tr>";
$body .= "    <th class=\"text-center\">#</th>";
$body .= "    <th class=\"text-start\">Descripción</th>";
$body .= "    <th class=\"text-center\">Porcentaje</th>";
$body .= "    <th class=\"text-center\">Opciones</th>";
$body .= "</tr>";
$list = $mcauses->where("plan", $oid)->orderBy("score", "DESC")->findAll();
$mayor = $mcauses->where("plan", $oid)->orderBy("score", "DESC")->first();

$count = 0;
foreach ($list as $item) {

    $options = "    <div class=\"btn-group\" role=\"group\">\n";
    if (($mayor["score"] > 0) && ($mayor["cause"] === $item["cause"])) {
        $options = "    <a class=\"btn btn-outline-danger\" href=\"/disa/mipg/plans/whys/list/{$item["cause"]}?c={$mayor["score"]}\" target=\"_self\"><i class=\"icon fas fa-bug\"></i></a>\n";
    }

    //$options= "    <a class=\"btn btn-outline-secondary\" href=\"/disa/mipg/plans/causes/edit/{$item["cause"]}\" target=\"_self\"><i class=\"icon far fa-eye\"></i> Ver</a>\n";
    $options .= "    <a class=\"btn btn-outline-secondary\" href=\"/disa/mipg/plans/causes/edit/{$item["cause"]}\" target=\"_self\"><i class=\"icon far fa-edit\"></i><span class=\"button-text\">Editar</span></a>\n";
    $options .= "    <a class=\"btn btn-outline-danger\" href=\"/disa/mipg/plans/causes/delete/{$item["cause"]}\" target=\"_self\"><i class=\"far fa-trash\"></i><span class=\"button-text\"> Eliminar</span></a>\n";
    $options .= "    </div>";

    $count++;
    $idescription = $strings->get_Clear(urldecode($item["description"]));
    $evaluation = (round($item["score"], 2) * 100) . "%";
    $body .= "<tr>";
    $body .= "    <td class=\"text-center\">{$count}</td>";
    $body .= "    <td>{$idescription}</td>";
    $body .= "    <td class=\"text-center\">" . ($evaluation) . "</td>";
    $body .= "    <td class=\"text-right\">{$options}</td>";
    $body .= "</tr>";
}

$body .= "</table>";

$menu = array(
    array("href" => "", "text" => "<i class=\"fas fa-check\"></i> Calificar"),
    array("href" => "#", "text" => "Ayuda")
);

if (count($list) == 0) {
    $sinfo = service("smarty");
    $sinfo->set_Mode("bs5x");
    $sinfo->caching = 0;
    $sinfo->assign("title", "Recuerde");
    $sinfo->assign("message", lang("Disa.causes-info-nocauses"));
    $info = ($sinfo->view('alerts/inline/info.tpl'));
    $body .= $info;
} elseif (count($list) <= 2) {
    $sinfo = service("smarty");
    $sinfo->set_Mode("bs5x");
    $sinfo->caching = 0;
    $sinfo->assign("title", "Importante");
    $sinfo->assign("message", lang("Disa.causes-info-2causes"));
    $info = ($sinfo->view('alerts/inline/info.tpl'));
    $body .= $info;
} elseif (count($list) >= 3) {
    $sinfo = service("smarty");
    $sinfo->set_Mode("bs5x");
    $sinfo->caching = 0;
    $sinfo->assign("title", "Recuerde");
    $sinfo->assign("message", lang("Disa.causes-info-3causes"));
    $info = ($sinfo->view('alerts/inline/info.tpl'));
    $body .= $info;
}


//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "PLAN",
    "log" => "Accedió a  <b>analisis de causas</b> del  <b>plan de acción</b> <b>{$plan['order']}</b>",
));


$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("class", "mb-3");
$card->assign("header", "Causas probables plan de acción " . $strings->get_ZeroFill($plan["order"], 4));
//$card->assign("header_menu", $menu);
$card->assign("header_back", "/disa/mipg/plans/view/{$oid}");
$card->assign("header_add", "/disa/mipg/plans/causes/create/{$oid}");
$card->assign("header_task", "/disa/mipg/plans/causes/evaluate/{$oid}");
$card->assign("text", false);
$card->assign("body", $body);
$card->assign("footer", false);
echo($card->view('components/cards/index.tpl'));

?>