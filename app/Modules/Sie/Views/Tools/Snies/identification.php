<?php

$bootstrap = service('bootstrap');
$data = $parent->get_Array();
$f = service("forms", array("lang" => "Sie_Registrations."));
//[vars]----------------------------------------------------------------------------------------------------------------
$r["identification_number"] = $f->get_Value("identification_number", "");
$back = "/sie/tools/snies/udpdate/home?" . lpk();
//[fields]---------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("step", "identification");
$f->fields["identification_number"] = $f->get_FieldText("identification_number", array("value" => $r["identification_number"], "proportion" => "col-12"));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => "Consultar", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["identification_number"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => "Consultar SNIES",
    "alert" => array(
        'type' => 'info',
        'title' => "Nota",
        'message' => "Ingrese su número de cedula para poder actualizar la información del SNIES"
    ),
    "content" => $f,
    "header-back" => $back,
));
echo($card);
?>