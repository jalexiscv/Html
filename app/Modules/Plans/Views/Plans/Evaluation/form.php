<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-02-03 16:17:50
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Plans\Views\Plans\Editor\form.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @var object $parent
 * █ @var object $authentication
 * █ @var object $request
 * █ @var object $dates
 * █ @var string $component
 * █ @var string $view
 * █ @var string $oid
 * █ @var string $views
 * █ @var string $prefix
 * █ @var array $data
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Plans_Plans."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Plans\Models\Plans_Plans");
$miplans = model('App\Modules\Plans\Models\Plans_Organization_Plans');
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->where('plan', $oid)->first();
$r["plan"] = $f->get_Value("plan", $row["plan"]);
$r["plan_institutional"] = $f->get_Value("plan_institutional", $row["plan_institutional"]);
$r["activity"] = $f->get_Value("activity", $row["activity"]);
$r["manager"] = $f->get_Value("manager", $row["manager"]);
$r["manager_subprocess"] = $f->get_Value("manager_subprocess", $row["manager_subprocess"]);
$r["manager_position"] = $f->get_Value("manager_position", $row["manager_position"]);
$r["order"] = $f->get_Value("order", $row["order"]);
$r["description"] = $f->get_Value("description", $row["description"]);
$r["formulation"] = $f->get_Value("formulation", $row["formulation"]);
$r["value"] = $f->get_Value("value", $row["value"]);
$r["start"] = $f->get_Value("start", $row["start"]);
$r["end"] = $f->get_Value("end", $row["end"]);
$r["evaluation"] = $f->get_Value("evaluation", $row["evaluation"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);

$r["status"] = "APPROVAL";
$r["status_evaluate"] = $f->get_Value("status_evaluate", $row["status_evaluate"]);
$r["status_date"] = $dates->get_Date();
$r["status_time"] = $dates->get_Time();
$r["status_evaluation"] = $f->get_Value("status_evaluation", $row["status_evaluation"]);

$back = "/plans/plans/view/" . $oid;
$plans = $miplans->get_SelectData();
array_push($plans, array("value" => "", "label" => "- Seleccione un plan -"));

$statuses = array(
    array("value" => "", "label" => "Seleccione una opción"),
    array("label" => "No cumplido(Parcial/Con errores)", "value" => "NOTCOMPLETED"),
    array("label" => "Cumplido(Totalmente)", "value" => "COMPLETED")
);


//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("author", $r["author"]);
$f->add_HiddenField("order", $r["order"]);

$f->fields["plan"] = $f->get_FieldText("plan", array("value" => $r["plan"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => "", "data" => $statuses, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["status_evaluate"] = $f->get_FieldViewArea("status_evaluate", array("value" => $r["status_evaluate"], "proportion" => "col-12"));
$f->fields["status_evaluation"] = $f->get_FieldTextArea("status_evaluation", array("value" => $r["status_evaluation"], "proportion" => "col-12"));
$f->fields["status_date"] = $f->get_FieldText("status_date", array("value" => $r["status_date"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["status_time"] = $f->get_FieldText("status_time", array("value" => $r["status_time"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));

$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Update"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));

//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["plan"] . $f->fields["status"] . $f->fields["status_date"] . $f->fields["status_time"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status_evaluate"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status_evaluation"])));

//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));

//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => "Respuesta de solicitud de evaluación del plan",
    "content" => $f,
    "header-back" => $back,
    "alert" => array(
        "type" => "info",
        "title" => lang("Plans_Plans.status-evaluation-title"),
        "message" => lang("Plans_Plans.status-evaluation-message"),
    ),
));
echo($card);
?>