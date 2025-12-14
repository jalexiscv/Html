<?php

//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Iso9001_Activities."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Iso9001\Models\Iso9001_Activities");
//[vars]----------------------------------------------------------------------------------------------------------------
$r["activity"] = $f->get_Value("activity", pk());
$r["category"] = $f->get_Value("category", $oid);
$r["order"] = $f->get_Value("order", "0");
$r["criteria"] = $f->get_Value("criteria");
$r["description"] = $f->get_Value("description");
$r["evaluation"] = $f->get_Value("evaluation");
$r["period"] = $f->get_Value("period");
$r["score"] = $f->get_Value("score", "0");
$r["multiplan"] = $f->get_Value("multiplan", "N");
$r["budget"] = $f->get_Value("budget", "0");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at");
$r["updated_at"] = $f->get_Value("updated_at");
$r["deleted_at"] = $f->get_Value("deleted_at");
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
$back = "/iso9001/activities/list/{$oid}";

//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["activity"] = $f->get_FieldText("activity", array("value" => $r["activity"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["category"] = $f->get_FieldText("category", array("value" => $r["category"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["order"] = $f->get_FieldNumber("order", array("value" => $r["order"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["criteria"] = $f->get_FieldCKEditor("criteria", array("value" => $r["criteria"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldCKEditor("description", array("value" => $r["description"], "proportion" => "col-12"));
$f->fields["evaluation"] = $f->get_FieldCKEditor("evaluation", array("value" => $r["evaluation"], "proportion" => "col-12"));
$f->fields["period"] = $f->get_FieldSelect("period", array("selected" => $r["period"], "data" => $periods, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["score"] = $f->get_FieldNumber("score", array("value" => $r["score"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "readonly" => true));
$f->fields["multiplan"] = $f->get_FieldSelect("multiplan", array("selected" => $r["multiplan"], "data" => $multiplans, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->fields["budget"] = $f->get_FieldNumber("budget", array("value" => $r["budget"], "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["activity"] . $f->fields["category"] . $f->fields["order"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["criteria"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["evaluation"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["period"] . $f->fields["score"] . $f->fields["multiplan"] . $f->fields["budget"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Iso9001_Activities.create-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
