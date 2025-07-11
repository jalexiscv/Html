<?php
/** @var  $bootstrap */
/** @var  $model */
/** @var  $oid */

$bootstrap = service("bootstrap");
$numbers = service("numbers");

$plan = $model->getPlan($oid);
$back = "/plans/plans/view/{$oid}";

$pstatus = "";
if ($plan['status'] == "COMPLETED") {
    $pstatus = "disabled";
}

//[models]--------------------------------------------------------------------------------------------------------------
$mplans = model('App\Modules\Plans\Models\Plans_Plans');
$mactions = model('App\Modules\Plans\Models\Plans_Actions');
$mattachments = model('App\Modules\Plans\Models\Plans_Attachments');
//[vars]----------------------------------------------------------------------------------------------------------------
$code = "";
$plan = $mplans->getPlan($oid);
$actions = $mactions->get_ListByPlan($oid);
$bgrid = $bootstrap->get_Grid();
$bgrid->set_Headers(array(
    array("content" => "#", "class" => "text-center text-nowrap align-middle"),
    array("content" => "Detalle(acción)", "class" => "text-center align-start"),
    array("content" => "Inicio", "class" => "text-center align-middle"),
    array("content" => "Finalización", "class" => "text-center align-middle"),
    array("content" => "Estado", "class" => "text-center align-middle"),
    array("content" => "Opciones", "class" => "text-center text-nowrap align-middle"),
));
$count = 0;
if (is_array($actions)) {
    foreach ($actions as $action) {
        $count++;
        $details = $action["variables"];
        $start = $action["start"];
        $end = $action["end"];
        $status = $action["status"];
        if ($status == "PROPOSED") {
            $status = "<span class=\"badge bg-secondary\">Propuesta</span>";
        } elseif ($status == "IN_PROGRESS") {
            $status = "<span class=\"badge bg-warning\">En progreso</span>";
        } elseif ($status == "APPROVED") {
            $status = "<span class=\"badge bg-primary\">Aprobada</span>";
        } elseif ($status == "COMPLETED") {
            $status = "<span class=\"badge bg-success\">Completada</span>";
        } elseif ($status == "CANCELED") {
            $status = "<span class=\"badge bg-danger\">Cancelada</span>";
        }

        $opciones = "<div class=\"btn-group w-auto\">";
        $attachments = $mattachments->get_FileListForObject($action["action"]);

        if (is_array($attachments) && count($attachments) > 0) {
            $opciones .= "<a href=\"/plans/actions/view/{$action["action"]}\" class=\"btn btn-sm btn-success\"><i class=\"fa-light fa-eye\"></i></a>";
        } else {
            $opciones .= "<a href=\"/plans/actions/view/{$action["action"]}\" class=\"btn btn-sm btn-danger\"><i class=\"fa-light fa-eye\"></i></a>";
        }

        if ($status == "PROPOSED" || $status == "REJECTED") {
            $opciones .= "<a href=\"/plans/actions/edit/{$action["action"]}\" class=\"btn btn-sm btn-warning\"><i class=\"fa-light fa-pen-to-square\"></i></a>";
            $opciones .= "<a href=\"/plans/actions/delete/{$action["action"]}\" class=\"btn btn-sm btn-danger\"><i class=\"fa-light fa-trash\"></i></a>";
        }
        $opciones .= "</div>";
        $cell_count = array("content" => $count, "class" => "text-center  align-middle",);
        $cell_details = array("content" => $details, "class" => "text-start  align-middle",);
        $cell_start = array("content" => $start, "class" => "text-center  align-middle",);
        $cell_end = array("content" => $end, "class" => "text-center  align-middle",);
        $cell_status = array("content" => $status, "class" => "text-center  align-middle",);
        $cell_opciones = array("content" => $opciones, "class" => "text-center d-flex justify-content-center  align-middle",);
        $bgrid->add_Row(array($cell_count, $cell_details, $cell_start, $cell_end, $cell_status, $cell_opciones));
    }
} else {
    //mensaje no hay mallas
}
//[info]----------------------------------------------------------------------------------------------------------------
$info = $bootstrap->get_Alert(array(
    'type' => 'secondary',
    'title' => lang("Plans_Actions.list-definition-info-title"),
    'message' => lang("Plans_Actions.list-definition-info-message"),
    'class' => 'mb-0'
));
//[build]---------------------------------------------------------------------------------------------------------------
$code = $bgrid;
$code .= $info;
$title = "Plan formulado";
$message = $plan['formulation'];
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => sprintf("Acciones del plan de acción %s", $numbers->pad_LeftWithZeros($plan['order'], 4)),
    "header-back" => $back,
    "header-add" => array("href" => "/plans/actions/create/{$oid}", "class" => " {$pstatus}"),
    //"footer-continue" => $back,
    "alert" => array(
        'type' => 'info',
        'title' => $title,
        'message' => $message
    ),
    "content" => $code,
));
echo($card);
?>