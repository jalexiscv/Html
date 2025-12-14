<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-12-18 01:37:20
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Security\Views\Users\Editor\form.php]
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
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Sie_Teachers."));
//[request]-------------------------------------------------------------------------------------------------------------
$row = $model->where('user', $oid)->first();
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');

$r["user"] = $oid;
$r["alias"] = $f->get_Value("alias", $mfields->get_Field($oid, "alias"));
$r["birthday"] = $f->get_Value("birthday", $mfields->get_Field($oid, "birthday"));
$r["citizenshipcard"] = $f->get_Value("citizenshipcard", $mfields->get_Field($oid, "citizenshipcard"));
$r["email"] = $f->get_Value("email", $mfields->get_Field($oid, "email"));
$r["email_personal"] = $f->get_Value("email_personal", $mfields->get_Field($oid, "email_personal"));
$r["firstname"] = $f->get_Value("firstname", $strings->get_URLDecode($mfields->get_Field($oid, "firstname")));
$r["lastname"] = $f->get_Value("lastname", $strings->get_URLDecode($mfields->get_Field($oid, "lastname")));
$r["password"] = $f->get_Value("password", '&nbsp;');
$r["confirm"] = $f->get_Value("confirm", '&nbsp;');
$r["phone"] = $f->get_Value("phone", $mfields->get_Field($oid, "phone"));
$r["whatsapp"] = $f->get_Value("whatsapp", $mfields->get_Field($oid, "whatsapp"));
$r["address"] = $f->get_Value("address", $mfields->get_Field($oid, "address"));
$r["reference"] = $f->get_Value("reference", $mfields->get_Field($oid, "reference"));
$r["notes"] = $f->get_Value("notes", $mfields->get_Field($oid, "notes"));
$r["expedition_date"] = $f->get_Value("expedition_date", $mfields->get_Field($oid, "expedition_date"));
$r["expedition_place"] = $f->get_Value("expedition_place", $mfields->get_Field($oid, "expedition_place"));
$r["author"] = $row["author"];
$r["gender"] = @$row["gender"];
$r["marital_status"] = @$row["marital_status"];
$back = "/sie/teachers/list/" . lpk();
//[fields]--------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("user", $r["user"]);
$f->add_HiddenField("author", $r["author"]);
$f->fields["alias"] = $f->get_FieldView("alias", array("value" => $r["alias"], "proportion" => "col-xl-4 col-md-12 col-12"));
$f->fields["birthday"] = $f->get_FieldView("birthday", array("value" => $r["birthday"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["citizenshipcard"] = $f->get_FieldView("citizenshipcard", array("value" => $r["citizenshipcard"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["password"] = $f->get_FieldView("password", array("value" => $r["password"], "proportion" => "col-xl-4 col-md-12 col-12"));
$f->fields["confirm"] = $f->get_FieldView("confirm", array("value" => $r["confirm"], "proportion" => "col-xl-4 col-md-12 col-12"));
$f->fields["email"] = $f->get_FieldView("email", array("value" => $r["email"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["email_personal"] = $f->get_FieldView("email_personal", array("value" => $r["email_personal"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["firstname"] = $f->get_FieldView("firstname", array("value" => $r["firstname"], "proportion" => "col-xl-4 col-md-4 col-12"));
$f->fields["lastname"] = $f->get_FieldView("lastname", array("value" => $r["lastname"], "proportion" => "col-xl-4 col-md-4 col-12"));
$f->fields["phone"] = $f->get_FieldView("phone", array("value" => $r["phone"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["whatsapp"] = $f->get_FieldView("whatsapp", array("value" => $r["whatsapp"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["address"] = $f->get_FieldView("address", array("value" => $r["address"], "proportion" => "col-xl-12 col-md-12 col-12"));
$f->fields["reference"] = $f->get_FieldView("reference", array("value" => $r["reference"], "proportion" => "col-xl-12 col-md-12 col-12"));
$f->fields["notes"] = $f->get_FieldView("notes", array("value" => $r["notes"], "proportion" => "col-xl-12 col-md-12 col-12"));
$f->fields["expedition_date"] = $f->get_FieldView("expedition_date", array("value" => $r["expedition_date"], "proportion" => "col-xl-6 col-md-6 col-12", "required" => true));
$f->fields["expedition_place"] = $f->get_FieldView("expedition_place", array("value" => $r["expedition_place"], "proportion" => "col-xl-6 col-md-6 col-12"));

$f->fields["gender"] = $f->get_FieldView("gender", array("value" => $r["gender"], "proportion" => "col-xl-6 col-md-12 col-12"));
$f->fields["marital_status"] = $f->get_FieldView("marital_status", array("value" => $r["marital_status"], "proportion" => "col-xl-6 col-md-12 col-12"));


$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/sie/teachers/list/" . lpk(), "text" => lang("App.Continue"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left disabled"));
//[groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("fields" => $f->fields["alias"] . $f->fields["password"] . $f->fields["confirm"]));
$f->groups["g2"] = $f->get_Group(array("fields" => $f->fields["firstname"] . $f->fields["lastname"]));
$f->groups["g3"] = $f->get_Group(array("fields" => $f->fields["gender"] . $f->fields["marital_status"]));
$f->groups["g4"] = $f->get_Group(array("fields" => $f->fields["address"]));
$f->groups["g5"] = $f->get_Group(array("fields" => $f->fields["email"] . $f->fields["email_personal"]));
$f->groups["g6"] = $f->get_Group(array("fields" => $f->fields["phone"] . $f->fields["whatsapp"]));
$f->groups["g7"] = $f->get_Group(array("fields" => $f->fields["birthday"] . $f->fields["citizenshipcard"]));
$f->groups["g8"] = $f->get_Group(array("fields" => $f->fields["expedition_date"] . $f->fields["expedition_place"]));
$f->groups["g9"] = $f->get_Group(array("fields" => $f->fields["reference"]));
$f->groups["g10"] = $f->get_Group(array("fields" => $f->fields["notes"]));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
echo($f);
?>