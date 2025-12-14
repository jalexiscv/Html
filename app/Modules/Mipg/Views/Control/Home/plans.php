<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use App\Libraries\Bootstrap;

/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
$authentication = service('authentication');
$strings = service('strings');
$request = service("request");
$dates = service("dates");

$dimension = $request->getGet("dimension");
$politic = $request->getGet("politic");
$diagnostic = $request->getGet("diagnostic");
$component = $request->getGet("component");
$category = $request->getGet("category");
$activity = $request->getGet("activity");

$bootstrap = new Bootstrap();
$javascript = "";

if (!empty($dimension) && !empty($politic) && !empty($diagnostic) && !empty($component) && !empty($category) && !empty($activity)) {
    $mactivities = model("\App\Modules\Mipg\Models\Mipg_Activities");
    $mplans = model("\App\Modules\Mipg\Models\Mipg_Plans");

    $activity = $mactivities->where("activity", $activity)->first();
    $plans = $mplans->where("activity", $activity["activity"])->orderBy("plan", "DESC")->findAll();
    // Texts
    $activity_name = urldecode($activity["description"]);

    $html = "";
    $html .= "<table class=\"table table-bordered border-gray\">";
    $html .= "<tr>";
    $html .= "<th class=\"text-center \" style=\"width:36px;\">#</th>";
    $html .= "<th class=\"text-start\">Plan de acción</th>";
    $html .= "<th class=\"text-center\" style=\"width:90px;\">Finalización</th>";
    $html .= "<th class=\"text-center\" style=\"width:100px;\">Estado</th>";
    $html .= "<th class=\"text-center\" style=\"width:32px;\"></th>";
    $html .= "<tr>";
    $count = 0;

    foreach ($plans as $plan) {
        $count++;
        if ($count == 1) {
            $order = $plan["order"];
            $score = $plan["value"];
            $name = urldecode($plan["description"]);
            $finalization = $plan["end"];
            //[status]--------------------------------------------------------------------------------------------------
            $mplans = model('App\Modules\Mipg\Models\Mipg_Plans');
            $mstatuses = model('App\Modules\Mipg\Models\Mipg_Statuses');
            $mactions = model('App\Modules\Mipg\Models\Mipg_Actions');
            $status = @$plan["status"];
            $observations = @$plan["observations"];
            $leftdays = $dates->get_leftTime($finalization, "days");// Dias que faltan para finalizar el plan

            if ($status === "PENDING" || empty($status)) {
                $actions = $mactions->get_ListByPlan($plan['plan']);
                if (count($actions) > 0) {
                    $smarty = service("smarty");
                    $smarty->assign("title", lang("Mipg.Plans-Status-Pending-title"));
                    $smarty->assign("message", lang("Mipg.Plans-Status-Pending-message-with-actions"));
                    $smarty->assign("continue", array("text" => lang("Mipg.Request-Approval"), "url" => "/disa/mipg/plans/statuses/approval/{$oid}", "class" => "btn-danger"));
                    $statusg = ($smarty->view('alerts/inline/denied.tpl'));
                } else {
                    $smarty = service("smarty");
                    $smarty->assign("title", lang("Mipg.Plans-Status-Pending-title"));
                    $smarty->assign("message", lang("Mipg.Plans-Status-Pending-message-not-actions"));
                    //$smarty->assign("continue", "/disa/mipg/plans/view/{$oid}");
                    $statusg = ($smarty->view('alerts/inline/denied.tpl'));
                }
            } elseif ($status === "APPROVAL") {
                if ($leftdays <= 5) {
                    $type = "danger";
                    $extra = "<hr><b>Esta a punto de vencerse</b>: {$finalization}";
                    $javascript .= "addClassToTableRow('activity-{$activity['activity']}', 'bg-danger');";
                    $javascript .= "addClassToTableRow('category-{$category}', 'bg-danger');";
                    $javascript .= "addClassToTableRow('component-{$component}', 'bg-danger');";
                    $javascript .= "addClassToTableRow('diagnostic-{$diagnostic}', 'bg-danger');";
                    $javascript .= "addClassToTableRow('politic-{$politic}', 'bg-danger');";
                    $javascript .= "addClassToTableRow('dimension-{$dimension}', 'bg-danger');";
                } else {
                    $type = "info";
                    $extra = "";
                }
                $statusg = $bootstrap->get_Alert(array(
                    'type' => $type,
                    'title' => lang('Mipg.statuses-approval-title'),
                    "message" => lang('Mipg.statuses-approval-message') . $extra
                ));
            } elseif ($status === "APPROVED") {
                if ($leftdays <= 5) {
                    $type = "danger";
                    $extra = "<hr><b>Esta a punto de vencerse</b>: {$finalization}";
                    $javascript .= "addClassToTableRow('activity-{$activity['activity']}', 'bg-danger');";
                    $javascript .= "addClassToTableRow('category-{$category}', 'bg-danger');";
                    $javascript .= "addClassToTableRow('component-{$component}', 'bg-danger');";
                    $javascript .= "addClassToTableRow('diagnostic-{$diagnostic}', 'bg-danger');";
                    $javascript .= "addClassToTableRow('politic-{$politic}', 'bg-danger');";
                    $javascript .= "addClassToTableRow('dimension-{$dimension}', 'bg-danger');";
                } else {
                    $type = "info";
                    $extra = "";
                }
                $statusg = $bootstrap->get_Alert(array(
                    'type' => $type,
                    'title' => lang('Mipg.statuses-approved-title'),
                    "message" => lang('Mipg.statuses-approved-message') . $extra
                ));
            } elseif ($status === "REJECTED") {
                $sinfo = service("smarty");
                $sinfo->set_Mode("bs5x");
                $sinfo->assign("title", lang("Mipg.statuses-rejected-status-title"));
                $sinfo->assign("message", sprintf(lang("Mipg.statuses-rejected-status-message"), $strings->get_Striptags($observations)));
                $sinfo->assign("continue", array("text" => lang("Mipg.Request-Approval"), "url" => "/disa/mipg/plans/statuses/approval/{$oid}", "class" => "btn-danger"));
                //$sinfo->assign("cancel", "/disa/mipg/plans/view/{$oid}");
                $statusg = ($sinfo->view('alerts/inline/danger.tpl'));
            } elseif ($status === "INEVALUATION") {
                $d["singular"] = "disa-plans-statuses-evaluate";
                $singular = $authentication->has_Permission($d["singular"]);
                if ($singular) {
                    $smarty = service("smarty");
                    $smarty->assign("title", lang("Mipg.statuses-evaluation-true-title"));
                    $smarty->assign("message", lang("Mipg_Mipg.statuses-evaluation-true-message"));
                    $smarty->assign("continue", array("text" => lang("Mipg.Evaluation"), "url" => "/disa/mipg/plans/statuses/evaluation/{$oid}", "class" => "btn-danger"));
                    $statusg = ($smarty->view('alerts/inline/denied.tpl'));
                } else {
                    $smarty = service("smarty");
                    $smarty->assign("title", lang("Mipg.statuses-evaluation-false-title"));
                    $smarty->assign("message", lang("Mipg.statuses-evaluation-false-message"));
                    $statusg = ($smarty->view('alerts/inline/denied.tpl'));
                }
            } elseif ($status === "COMPLETED") {
                $statusg = $bootstrap->get_Alert(array(
                    'type' => 'success',
                    'title' => lang('Mipg.statuses-completed-title'),
                    "message" => lang('Mipg.statuses-completed-message')
                ));
            } elseif ($status === "NOTCOMPLETED") {
                $observations = "<hr><b>Motivo del rechazo</b>: " . $observations;
                $sinfo = service("smarty");
                $sinfo->set_Mode("bs5x");
                $sinfo->assign("title", lang("Mipg.statuses-notcompleted-title"));
                $sinfo->assign("message", lang("Mipg_Mipg.statuses-notcompleted-message") . $observations);
                $sinfo->assign("continue", array("text" => lang("Mipg.statuses-notcompleted-request-evaluation"), "url" => "/disa/mipg/plans/statuses/evaluate/{$oid}", "class" => "btn-danger"));
                $statusg = ($sinfo->view('alerts/inline/danger.tpl'));
            } else {
                $sinfo = service("smarty");
                $sinfo->set_Mode("bs5x");
                $sinfo->assign("title", "Estado desconocido");
                $sinfo->assign("message", $status);
                $statusg = ($sinfo->view('alerts/inline/danger.tpl'));
            }
            //[/status]-------------------------------------------------------------------------------------------------
            if (!empty($status)) {
                if ($status == "APPROVAL") {
                    $status = "Solicitando aprobación";
                } elseif ($status == "REJECTED") {
                    $status = "Rechazado ";
                } elseif ($status == "APPROVED") {
                    $status = "Aprobado ";
                } elseif ($status == "EVALUATE") {
                    $status = "Solicitando evaluación ";
                } elseif ($status == "NOTCOMPLETED") {
                    $status = "No completado";
                } elseif ($status == "COMPLETED") {
                    $status = "Completo";
                } else {
                    $status = "{$status}";
                }
            }
            $html .= "<tr>";
            $html .= "<td class=\"text-center px-2-1\">{$order}</td>";
            $html .= "<td class=\"text-start px-2-1\">{$name} <br>Plan [<b>{$plan['plan']}</b>]<br>Actividad [<b>{$plan['activity']}</b>]</td>";
            $html .= "<td class=\"text-right px-2\">{$finalization}</td>";
            $html .= "<td class=\"text-center px-2\">$status</td>";
            $html .= "<td class=\"text-center px-2-1\"><a href=\"/mipg/plans/view/{$plan["plan"]}\" target=\"_blank\"><i class=\"fa fa-eye\"></i></a></td>";
            $html .= "</tr>";
        }
    }
    $html .= "</table>";
    echo($html);
    echo(@$statusg);
}
?>
<!-- [javaScript] -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function addClassToTableRow(rowId, className) {
            var rowElement = document.getElementById(rowId);
            if (rowElement) {
                rowElement.classList.add(className);
            } else {
                console.log('No se encontró un elemento con el ID ' + rowId);
            }
        }

        <?php echo($javascript);?>

    });
</script>
<!-- [/javaScript] -->
