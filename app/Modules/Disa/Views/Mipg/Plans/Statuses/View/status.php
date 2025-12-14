<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */


use App\Libraries\Strings;
use Config\Services;

$authentication = service('authentication');
$strings = new Strings();
$request = service('request');

$mplans = model('App\Modules\Disa\Models\Disa_Plans');
$mstatuses = model('App\Modules\Disa\Models\Disa_Statuses');
$mactions = model('App\Modules\Disa\Models\Disa_Actions');
$prefix = "Disa.Plans-Status";
$plan = $mplans->find($oid);

$row = $mstatuses->where("object", $oid)->orderBy("status", "DESC")->first();
$status = @$row["value"];
$observations = urldecode(@$row["observations"]);

if ($status === "PENDING" || empty($status)) {
    $actions = $mactions->get_ListByPlan($oid);
    if (count($actions) > 0) {
        $smarty = service("smarty");
        $smarty->assign("title", lang("Disa.Plans-Status-Pending-title"));
        $smarty->assign("message", lang("Disa.Plans-Status-Pending-message-with-actions"));
        $smarty->assign("continue", array("text" => lang("Disa.Request-Approval"), "url" => "/disa/mipg/plans/statuses/approval/{$oid}", "class" => "btn-danger"));
        echo($smarty->view('alerts/inline/denied.tpl'));
    } else {
        $smarty = service("smarty");
        $smarty->assign("title", lang("Disa.Plans-Status-Pending-title"));
        $smarty->assign("message", lang("Disa.Plans-Status-Pending-message-not-actions"));
        //$smarty->assign("continue", "/disa/mipg/plans/view/{$oid}");
        echo($smarty->view('alerts/inline/denied.tpl'));
    }
} elseif ($status === "APPROVAL") {
    $papprove = $authentication->has_Permission("disa-plans-statuses-approve");
    if ($papprove) {
        $sinfo = service("smarty");
        $sinfo->set_Mode("bs5x");
        $sinfo->assign("title", lang("Disa.statuses-papproval-status-title"));
        $sinfo->assign("message", lang("Disa.statuses-papproval-status-message"));
        $sinfo->assign("continue", array("url" => "/disa/mipg/plans/statuses/approve/{$oid}", "text" => "Revisar", "class" => "btn-danger"));
        //$sinfo->assign("cancel", "/disa/mipg/plans/view/{$oid}");
        echo($sinfo->view('alerts/inline/info.tpl'));
    } else {
        $sinfo = service("smarty");
        $sinfo->set_Mode("bs5x");
        $sinfo->assign("title", lang("Disa.statuses-approval-status-title"));
        $sinfo->assign("message", lang("Disa.statuses-approval-status-message"));
        $sinfo->assign("continue", "/disa/mipg/plans/statuses/approve/{$oid}");
        echo($sinfo->view('alerts/inline/info.tpl'));
    }
} elseif ($status === "APPROVED") {
    $completed = true;
    $actions = $mactions->where("plan", $oid)->find();
    foreach ($actions as $action) {
        $statusAction = $mstatuses->where("object", $action["action"])->orderBy("created_at", "DESC")->first();
        if ($statusAction["value"] != "COMPLETED") {
            $completed = false;
            break;
        }
    }
    if ($completed === true) {
        $sinfo = service("smarty");
        $sinfo->set_Mode("bs5x");
        $sinfo->assign("title", lang("Disa.statuses-completed-true-title"));
        $sinfo->assign("message", lang("Disa.statuses-completed-true-message"));
        $sinfo->assign("continue", array("text" => "Evaluación", "url" => "/disa/mipg/plans/statuses/evaluate/{$oid}", "class" => "btn-danger"));
        echo($sinfo->view('alerts/inline/info.tpl'));
    } else {
        $sinfo = service("smarty");
        $sinfo->set_Mode("bs5x");
        $sinfo->assign("title", lang("Disa.statuses-completed-false-title"));
        $sinfo->assign("message", lang("Disa.statuses-completed-false-message"));
        //$sinfo->assign("continue", "/disa/mipg/plans/statuses/approve/{$oid}");
        echo($sinfo->view('alerts/inline/info.tpl'));
    }
} elseif ($status === "REJECTED") {
    $sinfo = service("smarty");
    $sinfo->set_Mode("bs5x");
    $sinfo->assign("title", lang("Disa.statuses-rejected-status-title"));
    $sinfo->assign("message", sprintf(lang("Disa.statuses-rejected-status-message"), $strings->get_Striptags($observations)));
    $sinfo->assign("continue", array("text" => lang("Disa.Request-Approval"), "url" => "/disa/mipg/plans/statuses/approval/{$oid}", "class" => "btn-danger"));
    //$sinfo->assign("cancel", "/disa/mipg/plans/view/{$oid}");
    echo($sinfo->view('alerts/inline/danger.tpl'));
} elseif ($status === "INEVALUATION") {
    $d["singular"] = "disa-plans-statuses-evaluate";
    $singular = $authentication->has_Permission($d["singular"]);
    if ($singular) {
        $smarty = service("smarty");
        $smarty->assign("title", lang("Disa.statuses-evaluation-true-title"));
        $smarty->assign("message", lang("Disa.statuses-evaluation-true-message"));
        $smarty->assign("continue", array("text" => lang("Disa.Evaluation"), "url" => "/disa/mipg/plans/statuses/evaluation/{$oid}", "class" => "btn-danger"));
        echo($smarty->view('alerts/inline/denied.tpl'));
    } else {
        $smarty = service("smarty");
        $smarty->assign("title", lang("Disa.statuses-evaluation-false-title"));
        $smarty->assign("message", lang("Disa.statuses-evaluation-false-message"));
        echo($smarty->view('alerts/inline/denied.tpl'));
    }
} elseif ($status === "COMPLETED") {
    $observations = "<hr><b>Observaciones</b>: " . $observations;
    $sinfo = service("smarty");
    $sinfo->set_Mode("bs5x");
    $sinfo->assign("title", lang("Disa.statuses-completed-title"));
    $sinfo->assign("message", sprintf(lang("Disa.statuses-completed-message"), $plan["evaluation"]) . $observations);
    echo($sinfo->view('alerts/inline/success.tpl'));
} elseif ($status === "NOTCOMPLETED") {
    $observations = "<hr><b>Motivo del rechazo</b>: " . $observations;
    $sinfo = service("smarty");
    $sinfo->set_Mode("bs5x");
    $sinfo->assign("title", lang("Disa.statuses-notcompleted-title"));
    $sinfo->assign("message", lang("Disa.statuses-notcompleted-message") . $observations);
    $sinfo->assign("continue", array("text" => lang("Disa.statuses-notcompleted-request-evaluation"), "url" => "/disa/mipg/plans/statuses/evaluate/{$oid}", "class" => "btn-danger"));
    echo($sinfo->view('alerts/inline/danger.tpl'));
} else {
    $sinfo = service("smarty");
    $sinfo->set_Mode("bs5x");
    $sinfo->assign("title", "Estado desconocido");
    $sinfo->assign("message", $status);
    echo($sinfo->view('alerts/inline/danger.tpl'));
}


?>