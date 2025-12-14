<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-08-05 15:55:31
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Plans\Views\Plans\Editor\form.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2024 - CloudEngine S.A.S., Inc. <admin@cgine.com>
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
 * █ @Editor Anderson Ospina Lenis <andersonospina798@gmail.com>
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
$f = service("forms", array("lang" => "Mipg_Plans."));
//[models]--------------------------------------------------------------------------------------------------------------
$mplan = model("App\Modules\Plans\Models\Plans_Plans");
$mactivities = model('App\Modules\Mipg\Models\Mipg_Activities');
$miplans = model('App\Modules\Mipg\Models\Mipg_Organization_Plans');
$mprocesses = model('App\Modules\Mipg\Models\Mipg_Processes');

//[vars]----------------------------------------------------------------------------------------------------------------

$row = $mplan->where('plan', $oid)->first();
$activity = $mactivities->get_Activity($row["activity"]);
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
$back = "/mipg/plans/view/" . $oid;
$plans = $miplans->get_SelectData();
$processes = $mprocesses->get_SelectData();
array_push($plans, array("value" => "", "label" => "- Seleccione un plan -"));
array_push($processes, array("value" => "", "label" => "- Seleccione un proceso -"));
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["plan"] = $f->get_FieldText("plan", array("value" => $r["plan"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["plan_institutional"] = $f->get_FieldSelect("plan_institutional", array("selected" => $r["plan_institutional"], "data" => $plans, "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"));
$f->fields["activity"] = $f->get_FieldText("activity", array("value" => $r["activity"], "proportion" => "col-xl-3 col-lg-3 col-md-33 col-sm-12 col-12", "readonly" => true));
$f->fields["manager"] = $f->get_FieldSelect("manager", array("selected" => $r["manager"], "data" => $processes, "proportion" => "col-12"));
$f->fields["manager_subprocess"] = $f->get_FieldText("manager_subprocess", array("value" => $r["manager_subprocess"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["manager_position"] = $f->get_FieldText("manager_position", array("value" => $r["manager_position"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["order"] = $f->get_FieldText("order", array("value" => $r["order"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["formulation"] = $f->get_FieldText("formulation", array("value" => $r["formulation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["value"] = $f->get_FieldText("value", array("value" => $r["value"], "min" => $r["value"], "max" => "100", "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["range"] = $f->get_FieldDateRange("daterange", "end", array("start" => $r["start"], "end" => $r["end"], "proportion" => "col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"));
$f->fields["start"] = $f->get_FieldText("start", array("value" => $r["start"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["end"] = $f->get_FieldText("end", array("value" => $r["end"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["evaluation"] = $f->get_FieldText("evaluation", array("value" => $r["evaluation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);

$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["plan"] . $f->fields["activity"] . $f->fields["plan_institutional"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["value"] . $f->fields["range"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["manager"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "alert" => array(
        "type" => "info",
        'title' => lang("Mipg_Plans.info-create-title"),
        "message" => lang("Mipg_Plans.info-create-message")
    ),
    "title" => lang("Mipg_Plans.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
//[info]----------------------------------------------------------------------------------------------------------------
$info = $bootstrap->get_Card("card-view-service", array(
    "alert" => array(
        'type' => 'secondary',
        'title' => "¿Como se define el rango de recalificación propuesta?",
        'message' => $activity['evaluation'],
        'class' => 'mb-0'
    ),
));
echo($info);
?>
