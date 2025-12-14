<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-05-01 08:14:07
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\Editor\form.php]
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
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Registrations."));
//[models]--------------------------------------------------------------------------------------------------------------
$mprograms = model("App\Modules\Sie\Models\Sie_Programs");

//[requests]------------------------------------------------------------------------------------------------------------
$row = $model->getRegistration($oid);
$r["registration"] = $row["registration"];
$r["period"] = $row["period"];
$r["journey"] = $row["journey"];
$r["program"] = $row["program"];
$r["first_name"] = $row["first_name"];
$r["second_name"] = $row["second_name"];
$r["first_surname"] = $row["first_surname"];
$r["second_surname"] = $row["second_surname"];
$r["identification_type"] = $row["identification_type"];
$r["identification_number"] = $row["identification_number"];
$r["gender"] = $row["gender"];
$r["email_address"] = $row["email_address"];
$r["phone"] = $row["phone"];
$r["mobile"] = $row["mobile"];
$r["birth_date"] = $row["birth_date"];
$r["address"] = $row["address"];
$r["residence_city"] = $row["residence_city"];
$r["neighborhood"] = $row["neighborhood"];
$r["area"] = $row["area"];
$r["stratum"] = $row["stratum"];
$r["transport_method"] = $row["transport_method"];
$r["sisben_group"] = $row["sisben_group"];
$r["sisben_subgroup"] = $row["sisben_subgroup"];
$r["document_issue_place"] = $row["document_issue_place"];
$r["birth_city"] = $row["birth_city"];
$r["blood_type"] = $row["blood_type"];
$r["marital_status"] = $row["marital_status"];
$r["number_children"] = $row["number_children"];
$r["military_card"] = $row["military_card"];
$r["ars"] = $row["ars"];
$r["insurer"] = $row["insurer"];
$r["eps"] = $row["eps"];
$r["education_level"] = $row["education_level"];
$r["occupation"] = $row["occupation"];
$r["health_regime"] = $row["health_regime"];
$r["document_issue_date"] = $row["document_issue_date"];
$r["saber11"] = $row["saber11"];
$back = "/sie/registrations/list/" . lpk();
$program = $mprograms->getProgram($r["program"]);
$program_name = $r["program"] . "-" . $program["name"];

//[Fields]-----------------------------------------------------------------------------
$f->fields["registration"] = $f->get_FieldView("registration", array("value" => $r["registration"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["period"] = $f->get_FieldView("period", array("value" => $r["period"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["journey"] = $f->get_FieldView("journey", array("value" => $r["journey"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["program"] = $f->get_FieldView("program", array("value" => $program_name, "proportion" => "col-12"));

$f->fields["first_name"] = $f->get_FieldView("first_name", array("value" => $r["first_name"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["second_name"] = $f->get_FieldView("second_name", array("value" => $r["second_name"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["first_surname"] = $f->get_FieldView("first_surname", array("value" => $r["first_surname"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["second_surname"] = $f->get_FieldView("second_surname", array("value" => $r["second_surname"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["identification_type"] = $f->get_FieldView("identification_type", array("value" => $r["identification_type"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["identification_number"] = $f->get_FieldView("identification_number", array("value" => $r["identification_number"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["gender"] = $f->get_FieldView("gender", array("value" => $r["gender"], "proportion" => " col-md-3 col-sm-12 col-12"));
$f->fields["email_address"] = $f->get_FieldView("email_address", array("value" => $r["email_address"], "proportion" => " col-md-3 col-sm-12 col-12"));
$f->fields["phone"] = $f->get_FieldView("phone", array("value" => $r["phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["mobile"] = $f->get_FieldView("mobile", array("value" => $r["mobile"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["birth_date"] = $f->get_FieldView("birth_date", array("value" => $r["birth_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["address"] = $f->get_FieldView("address", array("value" => $r["address"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["residence_city"] = $f->get_FieldView("residence_city", array("value" => $r["residence_city"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["neighborhood"] = $f->get_FieldView("neighborhood", array("value" => $r["neighborhood"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["area"] = $f->get_FieldView("area", array("value" => $r["area"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["stratum"] = $f->get_FieldView("stratum", array("value" => $r["stratum"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["transport_method"] = $f->get_FieldView("transport_method", array("value" => $r["transport_method"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sisben_group"] = $f->get_FieldView("sisben_group", array("value" => $r["sisben_group"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sisben_subgroup"] = $f->get_FieldView("sisben_subgroup", array("value" => $r["sisben_subgroup"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_issue_place"] = $f->get_FieldView("document_issue_place", array("value" => $r["document_issue_place"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["birth_city"] = $f->get_FieldView("birth_city", array("value" => $r["birth_city"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["blood_type"] = $f->get_FieldView("blood_type", array("value" => $r["blood_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["marital_status"] = $f->get_FieldView("marital_status", array("value" => $r["marital_status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["number_children"] = $f->get_FieldView("number_children", array("value" => $r["number_children"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["military_card"] = $f->get_FieldView("military_card", array("value" => $r["military_card"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ars"] = $f->get_FieldView("ars", array("value" => $r["ars"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["insurer"] = $f->get_FieldView("insurer", array("value" => $r["insurer"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["eps"] = $f->get_FieldView("eps", array("value" => $r["eps"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["education_level"] = $f->get_FieldView("education_level", array("value" => $r["education_level"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["occupation"] = $f->get_FieldView("occupation", array("value" => $r["occupation"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["health_regime"] = $f->get_FieldView("health_regime", array("value" => $r["health_regime"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_issue_date"] = $f->get_FieldView("document_issue_date", array("value" => $r["document_issue_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["saber11"] = $f->get_FieldView("saber11", array("value" => $r["saber11"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/sie/registrations/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g01"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["registration"] . $f->fields["period"] . $f->fields["journey"])));
$f->groups["g02"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program"])));
$f->groups["g03"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["first_name"] . $f->fields["second_name"] . $f->fields["first_surname"] . $f->fields["second_surname"])));
$f->groups["g04"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["identification_type"] . $f->fields["identification_number"] . $f->fields["gender"] . $f->fields["email_address"])));
//$f->groups["g05"] = $f->get_Group(array("legend" => "", "fields" => ()));
$f->groups["g06"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["phone"] . $f->fields["mobile"] . $f->fields["birth_date"])));
$f->groups["g07"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["address"] . $f->fields["residence_city"] . $f->fields["neighborhood"])));
$f->groups["g08"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["area"] . $f->fields["stratum"] . $f->fields["transport_method"])));
$f->groups["g09"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["sisben_group"] . $f->fields["sisben_subgroup"] . $f->fields["document_issue_place"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["birth_city"] . $f->fields["blood_type"] . $f->fields["marital_status"])));
$f->groups["g11"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["number_children"] . $f->fields["military_card"] . $f->fields["ars"])));
$f->groups["g12"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["insurer"] . $f->fields["eps"] . $f->fields["education_level"])));
$f->groups["g13"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["occupation"] . $f->fields["health_regime"] . $f->fields["document_issue_date"])));
$f->groups["g14"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["saber11"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => "Preinscripción de {$r['first_name']} {$r['second_name']} {$r['first_surname']} {$r['second_surname']}",
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>
