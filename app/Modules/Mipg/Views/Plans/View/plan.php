<?php
/** @var  $bootstrap */
/** @var  $model */
/** @var  $oid */
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$numbers = service("numbers");
//[models]--------------------------------------------------------------------------------------------------------------
$mactivities = model('App\Modules\Mipg\Models\Mipg_Activities');
$mplans = model('App\Modules\Mipg\Models\Mipg_Plans');
$mcauses = model('App\Modules\Mipg\Models\Mipg_Causes');
$mwhys = model('App\Modules\Mipg\Models\Mipg_Whys');
$mactions = model('App\Modules\Mipg\Models\Mipg_Actions');
$mattachments = model('App\Modules\Mipg\Models\Mipg_Attachments');
//[vars]----------------------------------------------------------------------------------------------------------------
$plan = $mplans->getPlan($oid);
$activity = $mactivities->get_Activity($plan['activity']);
//$back = "/mipg/plans/home/{$plan['activity']}";
$back = "/mipg/activities/home/{$activity['category']}";


$options = array();

$options[] = array(
    "id" => "lgi-auto-register",
    "type" => "button",
    "href" => "/mipg/plans/details/{$oid}",
    "image" => "/themes/assets/images/icons/line_settings.svg",
    "alt" => "Detalles del plan",
    "title" => "<b>Detalles del plan</b><br>Descripción detalla del plan<br>Objetivo, indicadores, metas, etc. ",
    "timestamp" => "now",
);

$options[] = array(
    "id" => "lgi-team",
    "type" => "button",
    "href" => "/mipg/plans/team/{$oid}",
    "image" => "/themes/assets/images/icons/line_settings.svg",
    "alt" => "Equipo de trabajo",
    "title" => "<b>Equipo de trabajo</b><br>Es necesario que se defina un equipo de trabajo<br>Proceso, subproceso y cargo responsables ",
    "timestamp" => "now",
);

$options[] = array(
    "id" => "lgi-causes",
    "type" => "button",
    "href" => "/mipg/plans/causes/{$oid}",
    "image" => "/themes/assets/images/icons/line_settings.svg",
    "alt" => "Bootstrap Gallery",
    "title" => "<b>Análisis de causas</b><br>Determinación de la mayor causa probable...<br>Definición y estrategia de los 5 porque...",
    "timestamp" => "now",
);
$options[] = array(
    "id" => "lgi-formulation",
    "type" => "button",
    "href" => "/mipg/formulation/view/{$oid}",
    "image" => "/themes/assets/images/icons/line_settings.svg",
    "alt" => "Bootstrap Gallery",
    "title" => "<b>Formulación del plan</b><br>Conforme a la mayor causa probable definida...<br>Definición en función de los porque asociados...",
    "timestamp" => "now",
);


$options[] = array(
    "id" => "lgi-actions",
    "type" => "button",
    "href" => "/mipg/actions/home/{$oid}",
    "image" => "/themes/assets/images/icons/line_settings.svg",
    "alt" => "Acciones",
    "title" => "<b>Acciones</b><br>Definición de las acciones a realizar...<br>Responsables, fechas, recursos, etc. ",
    "timestamp" => "now",
);


/**
 * $options[] = array(
 * "id" => "lgi-2fa",
 * "type" => "button",
 * "href" => "/mipg/plans/risks/{$oid}",
 * "image" => "/themes/assets/images/icons/line_settings.svg",
 * "alt" => "Risk",
 * "title" => "Riesgos",
 * "timestamp" => "now",
 * );
 * **/

$editable = true;
if ($plan["status"] == "COMPLETED") {
    $editable = false;
}

$code = "";
$code .= "<table class=\"table table-striped table-hover\">\n";
$code .= "\t\t<thead>\n";
$code .= "\t\t\t\t<tr>\n";
$code .= "\t\t\t\t\t\t<th class=\"min-fit align-middle\" scope=\"col\"></th>\n";
$code .= "\t\t\t\t\t\t<th scope=\"col\">Detalle</th>\n";
$code .= "\t\t\t\t\t\t<th class=\"text-center min-fit align-middle text-nowrap\" scope=\"col\">Opciones</th>\n";
$code .= "\t\t\t\t</tr>\n";
$code .= "\t\t</thead>\n";
$code .= "\t\t<tbody>\n";
foreach ($options as $option) {


    if ($option['id'] == "lgi-team") {
        //$code .= ("Subproceso: " . $plan["manager_subprocess"] . "<br>");
        //$code .= ("Cargo: " . $plan["manager_position"] . "<br>");
        if (!empty($plan["manager_subprocess"]) && !empty($plan["manager_position"])) {
            $link = "<div class=\"btn-group float-right\" role=\"group\" aria-label=\"Basic example\">\n";
            $link .= "<a href=\"{$option['href']}\" class=\"btn btn-success\"><i class=\"fa-regular fa-regular fa-check\"></i></a>";
            $link .= "</div>\n";
            $code .= "\t\t\t\t\t <tr>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit align-middle text-nowrap\"><img src=\"{$option['image']}\"></td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"align-middle\">{$option['title']}</td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit text-center align-middle text-nowrap\">{$link}</td>\n";
            $code .= "\t\t\t\t\t </tr>\n";
        } else {
            $link = "<div class=\"btn-group float-right\" role=\"group\" aria-label=\"Basic example\">\n";
            $link .= "<a href=\"{$option['href']}\" class=\"btn btn-danger\"><i class=\"fa-regular fa-eye\"></i></a>";
            $link .= "</div>\n";
            $code .= "\t\t\t\t\t <tr>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit align-middle text-nowrap\"><img src=\"{$option['image']}\"></td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"align-middle\">{$option['title']}</td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit text-center align-middle text-nowrap\">{$link}</td>\n";
            $code .= "\t\t\t\t\t </tr>\n";
        }
    } elseif ($option['id'] == "lgi-causes") {
        $causes = $mcauses->get_List($oid, 1000, 0);
        $majorcause = $mcauses->get_MajorCause($oid);
        $whys = $mwhys->get_List(@$majorcause['cause'], 1000, 0);

        if (count($causes) > 0 && count($whys) > 0) {
            $link = "<div class=\"btn-group float-right\" role=\"group\" aria-label=\"Basic example\">\n";
            $link .= "<a href=\"{$option['href']}\" class=\"btn btn-success\"><i class=\"fa-regular fa-regular fa-check\"></i></a>";
            $link .= "</div>\n";
            $code .= "\t\t\t\t\t <tr>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit align-middle text-nowrap\"><img src=\"{$option['image']}\"></td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"align-middle\">{$option['title']}</td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit text-center align-middle text-nowrap\">{$link}</td>\n";
            $code .= "\t\t\t\t\t </tr>\n";
        } else {
            $link = "<div class=\"btn-group float-right\" role=\"group\" aria-label=\"Basic example\">\n";
            $link .= "<a href=\"{$option['href']}\" class=\"btn btn-danger\"><i class=\"fa-regular fa-eye\"></i></a>";
            $link .= "</div>\n";
            $code .= "\t\t\t\t\t <tr>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit align-middle text-nowrap\"><img src=\"{$option['image']}\"></td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"align-middle\">{$option['title']}</td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit text-center align-middle text-nowrap\">{$link}</td>\n";
            $code .= "\t\t\t\t\t </tr>\n";
        }
    } elseif ($option['id'] == "lgi-formulation") {
        $formulation = $plan['formulation'];
        if (!empty($formulation)) {
            $link = "<div class=\"btn-group float-right\" role=\"group\" aria-label=\"Basic example\">\n";
            $link .= "<a href=\"{$option['href']}\" class=\"btn btn-success\"><i class=\"fa-regular fa-regular fa-check\"></i></a>";
            $link .= "</div>\n";
            $code .= "\t\t\t\t\t <tr>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit align-middle text-nowrap\"><img src=\"{$option['image']}\"></td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"align-middle\">{$option['title']}</td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit text-center align-middle text-nowrap\">{$link}</td>\n";
            $code .= "\t\t\t\t\t </tr>\n";
        } else {
            $link = "<div class=\"btn-group float-right\" role=\"group\" aria-label=\"Basic example\">\n";
            $link .= "<a href=\"{$option['href']}\" class=\"btn btn-danger\"><i class=\"fa-regular fa-eye\"></i></a>";
            $link .= "</div>\n";
            $code .= "\t\t\t\t\t <tr>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit align-middle text-nowrap\"><img src=\"{$option['image']}\"></td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"align-middle\">{$option['title']}</td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit text-center align-middle text-nowrap\">{$link}</td>\n";
            $code .= "\t\t\t\t\t </tr>\n";
        }
    } elseif ($option['id'] == "lgi-actions") {
        $actions = $mactions->get_ListByPlan($oid);
        $actions_status = true;
        foreach ($actions as $action) {
            $attachments = $mattachments->get_FileListForObject($action['action']);
            if ($attachments == false || count($attachments) <= 0) {
                $actions_status = false;
                break;
            }
        }
        if ($actions_status && count($actions) > 0) {
            $link = "<div class=\"btn-group float-right\" role=\"group\" aria-label=\"Basic example\">\n";
            $link .= "<a href=\"{$option['href']}\" class=\"btn btn-success\"><i class=\"fa-regular fa-regular fa-check\"></i></a>";
            $link .= "</div>\n";
            $code .= "\t\t\t\t\t <tr>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit align-middle text-nowrap\"><img src=\"{$option['image']}\"></td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"align-middle\">{$option['title']}</td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit text-center align-middle text-nowrap\">{$link}</td>\n";
            $code .= "\t\t\t\t\t </tr>\n";
        } else {
            $link = "<div class=\"btn-group float-right\" role=\"group\" aria-label=\"Basic example\">\n";
            $link .= "<a href=\"{$option['href']}\" class=\"btn btn-danger\"><i class=\"fa-regular fa-eye\"></i></a>";
            $link .= "</div>\n";
            $code .= "\t\t\t\t\t <tr>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit align-middle text-nowrap\"><img src=\"{$option['image']}\"></td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"align-middle\">{$option['title']}</td>\n";
            $code .= "\t\t\t\t\t\t <td class=\"min-fit text-center align-middle text-nowrap\">{$link}</td>\n";
            $code .= "\t\t\t\t\t </tr>\n";
        }
    } else {
        $link = "<div class=\"btn-group float-right\" role=\"group\" aria-label=\"Basic example\">\n";
        $link .= "<a href=\"{$option['href']}\" class=\"btn btn-primary\"><i class=\"fa-regular fa-eye\"></i></a>";
        $link .= "</div>\n";
        $code .= "\t\t\t\t\t <tr>\n";
        $code .= "\t\t\t\t\t\t <td class=\"min-fit align-middle text-nowrap\"><img src=\"{$option['image']}\"></td>\n";
        $code .= "\t\t\t\t\t\t <td class=\"align-middle\">{$option['title']}</td>\n";
        $code .= "\t\t\t\t\t\t <td class=\"min-fit text-center align-middle text-nowrap\">{$link}</td>\n";
        $code .= "\t\t\t\t\t </tr>\n";
    }


}
$code .= "\t\t</tbody>\n";
$code .= "</table>\n";


$card = $bootstrap->get_Card("card-view-service", array(
    "title" => sprintf("Plan de acción %s", $numbers->pad_LeftWithZeros($plan['order'], 4)),
    "header-back" => $back,
    "header-edit" => (($editable) ? "/mipg/plans/edit/{$oid}" : ""),
    //"footer-continue" => $back,
    "content" => $code,
));
echo($card);
?>