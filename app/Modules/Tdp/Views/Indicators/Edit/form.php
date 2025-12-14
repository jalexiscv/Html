<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-03-26 14:31:43
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Tdp\Views\Indicators\Editor\form.php]
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
 * █ @var object $parent Trasferido desde el controlador
 * █ @var object $authentication Trasferido desde el controlador
 * █ @var object $request Trasferido desde el controlador
 * █ @var object $dates Trasferido desde el controlador
 * █ @var string $component Trasferido desde el controlador
 * █ @var string $view Trasferido desde el controlador
 * █ @var string $oid Trasferido desde el controlador
 * █ @var string $views Trasferido desde el controlador
 * █ @var string $prefix Trasferido desde el controlador
 * █ @var array $data Trasferido desde el controlador
 * █ @var object $model Modelo de datos utilizado en la vista y trasferido desde el index
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Indicators."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Tdp\Models\Tdp_Indicators");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->where('indicator', $oid)->first();
$r["indicator"] = $f->get_Value("indicator", $row["indicator"]);
$r["product"] = $f->get_Value("product", $row["product"]);
$r["order"] = $f->get_Value("order", $row["order"]);
$r["criteria"] = $f->get_Value("criteria", $row["criteria"]);
$r["description"] = $f->get_Value("description", $row["description"]);
$r["evaluation"] = $f->get_Value("evaluation", $row["evaluation"]);
$r["period"] = $f->get_Value("period", $row["period"]);
$r["score"] = $f->get_Value("score", $row["score"]);
$r["multiplan"] = $f->get_Value("multiplan", $row["multiplan"]);
$r["budget"] = $f->get_Value("budget", $row["budget"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$multiplans = array(
    array("label" => "Si", "value" => "Y"),
    array("label" => "No", "value" => "N"),
);
$periods = array(
    array("label" => "Al Dia", "value" => "OK"),
    array("label" => "En proceso", "value" => "INPROGRESS"),
    array("label" => "Finalizado", "value" => "FINISHED"),
    array("label" => "Aplazado", "value" => "POSTPONED"),
    array("label" => "Cancelado", "value" => "CANCELLED"),
    array("label" => "Pendiente", "value" => "PENDING"),
    array("label" => "En revisión", "value" => "UNDERREVIEW"),
    array("label" => "En espera", "value" => "ONHOLD"),
    array("label" => "Rechazado", "value" => "REJECTED"),
    array("label" => "En curso", "value" => "ONGOING"),
    array("label" => "Programado", "value" => "SCHEDULED"),
    array("label" => "En evaluación", "value" => "UNDEREVALUATION"),
    array("label" => "En desarrollo", "value" => "INDEVELOPMENT"),
    array("label" => "Suspendido", "value" => "SUSPENDED"),
    array("label" => "No iniciado", "value" => "NOTSTARTED")
);
$back = "/tdp/indicators/list/" . $r["product"];
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["indicator"] = $f->get_FieldText("indicator", array("value" => $r["indicator"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["product"] = $f->get_FieldText("product", array("value" => $r["product"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["order"] = $f->get_FieldNumber("order", array("value" => $r["order"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["criteria"] = $f->get_FieldCKEditor("criteria", array("value" => $r["criteria"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldCKEditor("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["evaluation"] = $f->get_FieldCKEditor("evaluation", array("value" => $r["evaluation"], "proportion" => "col-12"));
$f->fields["period"] = $f->get_FieldSelect("period", array("selected" => $r["period"], "data" => $periods, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["score"] = $f->get_FieldText("score", array("value" => $r["score"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["multiplan"] = $f->get_FieldSelect("multiplan", array("selected" => $r["multiplan"], "data" => $multiplans, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["budget"] = $f->get_FieldNumber("budget", array("value" => $r["budget"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["indicator"] . $f->fields["product"] . $f->fields["order"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["criteria"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["evaluation"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["period"] . $f->fields["score"] . $f->fields["multiplan"] . $f->fields["budget"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => lang("Indicators.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
