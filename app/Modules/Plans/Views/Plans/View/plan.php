<?php
/** @var  $bootstrap */
/** @var  $model */
/** @var  $oid */
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$numbers = service("numbers");
//[models]--------------------------------------------------------------------------------------------------------------
$mactivities = model('App\Modules\Plans\Models\Plans_Activities');
$mplans = model('App\Modules\Plans\Models\Plans_Plans');
$mcauses = model('App\Modules\Plans\Models\Plans_Causes');
$mwhys = model('App\Modules\Plans\Models\Plans_Whys');
$mactions = model('App\Modules\Plans\Models\Plans_Actions');
$mattachments = model('App\Modules\Plans\Models\Plans_Attachments');
//[vars]----------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Plans_Plans."));
$plan = $mplans->getPlan($oid);
//$activity = $mactivities->get_Activity($plan['activity']);
//$back = "/plans/plans/home/{$plan['activity']}";

//$back = "/plans/activities/home/{$activity['category']}";
$back = "#";
$editable = true;
if ($plan["status"] == "COMPLETED") {
    $editable = false;
}


$options = array();

$options[] = array(
    "id" => "lgi-team",
    "type" => "button",
    "href" => "/plans/plans/team/{$oid}",
    "image" => "/themes/assets/images/icons/line_settings.svg",
    "alt" => "Equipo de trabajo",
    "title" => "<b>Equipo de trabajo</b><br>Es necesario que se defina un equipo de trabajo<br>Proceso, subproceso y cargo responsables ",
    "timestamp" => "now",
);

$options[] = array(
    "id" => "lgi-causes",
    "type" => "button",
    "href" => "/plans/plans/causes/{$oid}",
    "image" => "/themes/assets/images/icons/line_settings.svg",
    "alt" => "Bootstrap Gallery",
    "title" => "<b>Análisis de causas</b><br>Determinación de la mayor causa probable...<br>Definición y estrategia de los 5 porque...",
    "timestamp" => "now",
);
$options[] = array(
    "id" => "lgi-formulation",
    "type" => "button",
    "href" => "/plans/formulation/view/{$oid}",
    "image" => "/themes/assets/images/icons/line_settings.svg",
    "alt" => "Bootstrap Gallery",
    "title" => "<b>Formulación del plan</b><br>Conforme a la mayor causa probable definida...<br>Definición en función de los porque asociados...",
    "timestamp" => "now",
);


$options[] = array(
    "id" => "lgi-actions",
    "type" => "button",
    "href" => "/plans/actions/home/{$oid}",
    "image" => "/themes/assets/images/icons/line_settings.svg",
    "alt" => "Acciones",
    "title" => "<b>Acciones</b><br>Definición de las acciones a realizar...<br>Responsables, fechas, recursos, etc. ",
    "timestamp" => "now",
);


/**
 * $options[] = array(
 * "id" => "lgi-2fa",
 * "type" => "button",
 * "href" => "/plans/plans/risks/{$oid}",
 * "image" => "/themes/assets/images/icons/line_settings.svg",
 * "alt" => "Risk",
 * "title" => "Riesgos",
 * "timestamp" => "now",
 * );
 * **/

$code = "";

$r = $plan;

$f->fields["plan"] = $f->get_FieldView("plan", array("value" => $r["plan"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["module"] = $f->get_FieldView("module", array("value" => $r["module"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["plan_institutional"] = $f->get_FieldView("plan_institutional", array("value" => $r["plan_institutional"], "proportion" => "col-md-4 col-sm-12 col-12"));
$f->fields["activity"] = $f->get_FieldView("activity", array("value" => $r["activity"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["manager"] = $f->get_FieldView("manager", array("value" => $r["manager"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["manager_subprocess"] = $f->get_FieldView("manager_subprocess", array("value" => $r["manager_subprocess"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["manager_position"] = $f->get_FieldView("manager_position", array("value" => $r["manager_position"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["order"] = $f->get_FieldView("order", array("value" => $r["order"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldView("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["formulation"] = $f->get_FieldView("formulation", array("value" => $r["formulation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["score"] = $f->get_FieldView("score", array("value" => $r["score"], "min" => $r["score"], "max" => "100", "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["value"] = $f->get_FieldView("value", array("value" => $r["value"], "min" => $r["value"], "max" => "100", "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["range"] = $f->get_FieldView("daterange", "end", array("start" => $r["start"], "end" => $r["end"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["start"] = $f->get_FieldView("start", array("value" => $r["start"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["end"] = $f->get_FieldView("end", array("value" => $r["end"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["evaluation"] = $f->get_FieldView("evaluation", array("value" => $r["evaluation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["plan"] . $f->fields["module"] . $f->fields["plan_institutional"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["score"] . $f->fields["value"] . $f->fields["start"] . $f->fields["end"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));


$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => sprintf("Plan de acción %s", $numbers->pad_LeftWithZeros($plan['order'], 4)),
    "header-back" => $back,
    "header-edit" => (($editable) ? "/plans/plans/edit/{$oid}" : ""),
    //"footer-continue" => $back,
    "content" => $f,
));
echo($card);

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


$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => "Gestión",
    //"header-back" => $back,
    //"header-edit" => (($editable) ? "/plans/plans/edit/{$oid}" : ""),
    //"footer-continue" => $back,
    "content" => $code,
));
echo($card);
?>