<?php

use App\Libraries\Bootstrap;
use App\Libraries\Grid;

use App\Libraries\Strings;

$authentication = service('authentication');
$strings = new Strings();

$mplans = model("App\Modules\Disa\Models\Disa_Plans");
$mcauses = model("App\Modules\Disa\Models\Disa_Causes");
$mactions = model("App\Modules\Disa\Models\Disa_Actions");
$mstatuses = model('App\Modules\Disa\Models\Disa_Statuses');

$plan = $mplans->find($oid);
$formulation = $strings->get_Striptags(urldecode($plan["formulation"]));
$status_plan = $mstatuses->where("object", $plan["plan"])->orderby("created_at", "DESC")->first();

$warning = service("smarty");
$warning->set_Mode("bs5x");
$warning->caching = 0;
$warning->assign("title", "Plan formulado");
$warning->assign("message", "{$formulation}");
$body = ($warning->view('alerts/inline/warning.tpl'));

$body .= "<table class=\"table table-bordered table-hover\">";
$body .= "<tr>";
$body .= "    <th class=\"text-center\">#</th>";
$body .= "    <th class=\"text-start\">Detalle(acción)</th>";
$body .= "    <th class=\"text-center\">Inicio</th>";
$body .= "    <th class=\"text-center\">Finalización</th>";
$body .= "    <th class=\"text-center\">Estado</th>";
$body .= "    <th class=\"text-center\">Opciones</th>";
$body .= "</tr>";
$list = $mactions->where("plan", $oid)->orderBy("action", "DESC")->findAll();
$count = 0;
foreach ($list as $item) {
    $options = "    <div class=\"btn-group\" role=\"group\">\n";
    $options = "    <a class=\"btn btn-outline-secondary\" href=\"/disa/mipg/plans/actions/view/{$item["action"]}\" target=\"_self\"><i class=\"icon far fa-eye\"></i></a>\n";
    $options .= "    <a class=\"btn btn-outline-secondary\" href=\"/disa/mipg/plans/actions/edit/{$item["action"]}\" target=\"_self\"><i class=\"icon far fa-edit\"></i></a>\n";
    $options .= "    <a class=\"btn btn-outline-danger\" href=\"/disa/mipg/plans/actions/delete/{$item["action"]}\" target=\"_self\"><i class=\"far fa-trash\"></i></a>\n";
    $options .= "    </div>";
    $count++;
    $variables = urldecode($item["variables"]);
    $status = $mstatuses->where("object", $item["action"])->orderby("created_at", "DESC")->first();
    $ostatus = "";
    if (is_array($status) && $status["value"] == "APPROVED") {
        $ostatus = "<a href=\"/disa/mipg/plans/actions/status/{$item["action"]}\" class=\"btn btn-warning btn-block\">" . lang("Disa." . $status["value"]) . "</a>";
    } else {
        if (isset($status["value"]) && $status["value"] == "PROPOSED") {
            $ostatus = "<a href=\"#\" class=\"btn btn-primary btn-block\">" . lang("Disa." . $status["value"]) . "</a>";
        } else {
            $ostatus = "<a href=\"#\" class=\"btn btn-success btn-block\">" . lang("Disa." . @$status["value"]) . "</a>";
        }
    }
    $body .= "<tr>";
    $body .= "    <td class=\"text-center\">{$count}</td>";
    $body .= "    <td>{$variables}</td>";
    $body .= "    <td class=\"text-center\">{$item["start"]}</td>";
    $body .= "    <td class=\"text-center\">{$item["end"]}</td>";
    $body .= "    <td class=\"text-center\">{$ostatus}</td>";
    $body .= "    <td class=\"text-center p-2\">{$options}</td>";
    $body .= "</tr>";
}

$body .= "</table>";
$menu = array(
    array("href" => "/disa/mipg/plans/causes/create/{$oid}", "text" => "<i class=\"fas fa-chevron-left\"></i> Crear"),
    array("href" => "/disa/mipg/plans/causes/evaluate/{$oid}", "text" => "<i class=\"fas fa-check\"></i> Calificar"),
    array("href" => "#", "text" => "Ayuda")
);


//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "PLAN",
    "log" => "Accedió a  <b>las acciones</b> del  <b>plan de acción</b> <b>{$plan['order']}</b>",
));


$sinfo = service("smarty");
$sinfo->set_Mode("bs5x");
$sinfo->caching = 0;
$sinfo->assign("title", "Recuerde");
$sinfo->assign("message", lang("Disa.actions-list-info"));
$info = ($sinfo->view('alerts/inline/info.tpl'));


$card = service("smarty");
$card->set_Mode("bs5x");
$card->caching = 0;
$card->assign("type", "normal");
$card->assign("class", "mb-3");
$card->assign("header", "Acciones del plan " . $strings->get_ZeroFill($plan["order"], 4));
$card->assign("header_menu", $menu);
$card->assign("header_back", "/disa/mipg/plans/view/{$oid}");
$card->assign("header_add", "/disa/mipg/plans/actions/create/{$oid}");
$card->assign("text", false);
$card->assign("body", $body . $info);
$card->assign("footer", false);
echo($card->view('components/cards/index.tpl'));

?>