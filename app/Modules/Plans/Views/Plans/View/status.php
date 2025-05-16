<?php
$authentication = service('authentication');
$bootstrap = service('bootstrap');
//[models]--------------------------------------------------------------------------------------------------------------
$mplans = model('App\Modules\Plans\Models\Plans_Plans');
$mactions = model('App\Modules\Plans\Models\Plans_Actions');
$mattachments = model('App\Modules\Plans\Models\Plans_Attachments');
//[vars]----------------------------------------------------------------------------------------------------------------
$plan = $mplans->getPlan($oid);
$status = $plan['status'];

if ($status == "PENDING" || empty($status)) {
    $actions = $mactions->get_ListByPlan($oid);
    if (count($actions) > 0) {
        $href = "/plans/plans/approval/{$oid}";
        $btn = "</br><a href=\"{$href}\" class=\"btn btn-primary mt-2\">Solicitar Aprobación</a>";
        $alert = array(
            "type" => "info",
            "title" => lang("Plans_Plans.status-pendding-title"),
            "message" => lang("Plans_Plans.status-pendding-message") . $btn,
        );
        echo($bootstrap->get_Alert($alert));
    } else {
        $alert = array(
            "type" => "danger",
            "title" => lang("Plans_Plans.status-no-actions-title"),
            "message" => lang("Plans_Plans.status-no-actions-message"),
        );
        echo($bootstrap->get_Alert($alert));
    }
} elseif ($status == "APPROVAL") {
    if ($authentication->has_Permission("PLANS-PLANS-APPROVE")) {
        $href = "/plans/plans/approve/{$oid}";
        $btn = "</br><a href=\"{$href}\" class=\"btn btn-primary mt-2\">Dar respuesta</a>";
        $alert = array(
            "type" => "info",
            "title" => "Se ha solicitado se apruebe el plan de acción",
            "message" => "Actualmente el plan de acción se encuentra formulado. Ya que usted posee los permisos de acceso requeridos podrá dar aprobación o rechazar el plan acción." . $btn,
        );
    } else {
        $alert = array(
            "type" => "info",
            "title" => "Notificación",
            "message" => "Se ha solicitado se apruebe el plan de acción: Actualmente el plan de acción se encuentra a la espera de ser aprobado o rechazado por el coordinador. Al ser aprobado o rechazado el plan de acción le será generada una notificación automática con los pormenores del procedimiento.",
        );
    }
    echo($bootstrap->get_Alert($alert));
} elseif ($status == "REJECTED") {
    $href = "/plans/plans/approval/{$oid}";
    $btn = "</br><a href=\"{$href}\" class=\"btn btn-primary mt-2\">Solicitar Aprobación</a>";
    $alert = array(
        "type" => "warning",
        "title" => "Advertencia",
        "message" => "El plan de acción ha sido rechazado con el siguiente mensaje: <hr>{$plan['status_approve']} <hr> por favor realice la verificación sugerida y vuelva a solicitar su revisión." . $btn,
    );
    echo($bootstrap->get_Alert($alert));
} elseif ($status == "APPROVED") {
    $evidencias = false;
    //Listado de todas las acciones del plan
    //Una por una reviso si tienen evidencias
    $actions = $mactions->get_ListByPlan($oid);
    foreach ($actions as $action) {
        $attachments = $mattachments->get_FileListForObject($action["action"]);
        if (is_array($attachments) && count($attachments) > 0) {
            $evidencias = true;
        } else {
            $evidencias = false;
            break;
        }
    }

    if ($evidencias == true) {
        $href = "/plans/plans/evaluate/{$oid}";
        $btn = "</br><a href=\"{$href}\" class=\"btn btn-primary mt-2\">Solicitar evaluación</a>";
        $alert = array(
            "type" => "info",
            "title" => "Advertencia",
            "message" => "El plan de acción ha sido Aprobado con el siguiente mensaje:<hr>{$plan['status_approve']} <hr> Por favor realice las acciones aprobadas y cargue las evidencias para poder solicitar la evaluación del mismo. Una vez todas las acciones tengan evidencias se habilitará el botón de solicitar evaluación." . $btn,
        );
    } else {
        $btn = "</br><a href=\"#\" class=\"btn btn-gray mt-2 disabled\">Solicitar evaluación</a>";
        $alert = array(
            "type" => "warning",
            "title" => "Advertencia",
            "message" => "El plan de acción ha sido Aprobado con el siguiente mensaje:<hr>{$plan['status_approve']} <hr> Por favor realice las acciones aprobadas y cargue las evidencias para poder solicitar la evaluación del mismo. Una vez todas las acciones tengan evidencias se habilitará el botón de solicitar evaluación." . $btn,
        );
    }
    echo($bootstrap->get_Alert($alert));
} elseif ($status == "EVALUATE") {
    if ($authentication->has_Permission("PLANS-PLANS-APPROVE")) {
        $href = "/plans/plans/evaluation/{$oid}";
        $btn = "</br><a href=\"{$href}\" class=\"btn btn-primary mt-2\">Evaluar plan</a>";
        $alert = array(
            "type" => "info",
            "title" => "Se ha solicitado se Evalúe el plan de acción",
            "message" => "Actualmente el plan de acción se encuentra a la espera de ser Evaluado o rechazado por el coordinador." . $btn,
        );
    } else {
        $alert = array(
            "type" => "info",
            "title" => "Se ha solicitado se Evalúe el plan de acción",
            "message" => "Actualmente el plan de acción se encuentra a la espera de ser Evaluado o rechazado por el coordinador.",
        );
    }
    echo($bootstrap->get_Alert($alert));

} elseif ($status == "NOTCOMPLETED") {

    $href = "/plans/plans/evaluate/{$oid}";
    $btn = "</br><a href=\"{$href}\" class=\"btn btn-primary mt-2\">Reevaluar plan</a>";
    $alert = array(
        "type" => "info",
        "title" => "No completado",
        "message" => "El plan de acción ha sido Evaluado como NO Cumplido, con el siguiente mensaje:<hr>{$plan['status_evaluation']}<hr> Por favor cargue las evidencias adecuadas para poder solicitar la terminación del mismo." . $btn,
    );
    echo($bootstrap->get_Alert($alert));
} elseif ($status == "COMPLETED") {
    $alert = array(
        "type" => "success",
        "title" => "Completado",
        "message" => "Plan de acción completado exitosamente.",
    );
    echo($bootstrap->get_Alert($alert));
} else {
    echo($status);
}
?>