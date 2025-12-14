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
$f = service("forms", array("lang" => "Users."));
//[request]-------------------------------------------------------------------------------------------------------------
$row = $model->where('user', $oid)->first();
$mfields = model("App\Modules\Security\Models\Security_Users_Fields");

$r["user"] = $oid;
$r["alias"] = $f->get_Value("alias", $mfields->get_Field($oid, "alias"));
$r["birthday"] = $f->get_Value("birthday", $mfields->get_Field($oid, "birthday"));
$r["citizenshipcard"] = $f->get_Value("citizenshipcard", $mfields->get_Field($oid, "citizenshipcard"));
$r["email"] = $f->get_Value("email", $mfields->get_Field($oid, "email"));
$r["firstname"] = $f->get_Value("firstname", $strings->get_URLDecode($mfields->get_Field($oid, "firstname")));
$r["lastname"] = $f->get_Value("lastname", $strings->get_URLDecode($mfields->get_Field($oid, "lastname")));
$r["password"] = $f->get_Value("password", '&nbsp;');
$r["confirm"] = $f->get_Value("confirm", '&nbsp;');
$r["phone"] = $f->get_Value("phone", $mfields->get_Field($oid, "phone"));
$r["address"] = $f->get_Value("address", $mfields->get_Field($oid, "address"));
$r["reference"] = $f->get_Value("reference", $mfields->get_Field($oid, "reference"));
$r["notes"] = $f->get_Value("notes", $mfields->get_Field($oid, "notes"));
$r["expedition_date"] = $f->get_Value("expedition_date", $mfields->get_Field($oid, "expedition_date"));
$r["expedition_place"] = $f->get_Value("expedition_place", $mfields->get_Field($oid, "expedition_place"));
$r["sie-registration"] = $f->get_Value("sie-registration", $mfields->get_Field($oid, "sie-registration"));

$r["author"] = $row["author"];
$back = "/security/users/list/" . lpk();
//[fields]--------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("user", $r["user"]);
$f->add_HiddenField("author", $r["author"]);
$f->fields["alias"] = $f->get_FieldView("alias", array("value" => $r["alias"], "proportion" => "col-xl-4 col-md-12 col-12"));
$f->fields["birthday"] = $f->get_FieldView("birthday", array("value" => $r["birthday"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["citizenshipcard"] = $f->get_FieldView("citizenshipcard", array("value" => $r["citizenshipcard"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["password"] = $f->get_FieldView("password", array("value" => $r["password"], "proportion" => "col-xl-4 col-md-12 col-12"));
$f->fields["confirm"] = $f->get_FieldView("confirm", array("value" => $r["confirm"], "proportion" => "col-xl-4 col-md-12 col-12"));
$f->fields["email"] = $f->get_FieldView("email", array("value" => $r["email"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["firstname"] = $f->get_FieldView("firstname", array("value" => $r["firstname"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["lastname"] = $f->get_FieldView("lastname", array("value" => $r["lastname"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["phone"] = $f->get_FieldView("phone", array("value" => $r["phone"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["address"] = $f->get_FieldView("address", array("value" => $r["address"], "proportion" => "col-xl-12 col-md-12 col-12"));
$f->fields["reference"] = $f->get_FieldView("reference", array("value" => $r["reference"], "proportion" => "col-xl-12 col-md-12 col-12"));
$f->fields["notes"] = $f->get_FieldView("notes", array("value" => $r["notes"], "proportion" => "col-xl-12 col-md-12 col-12"));
$f->fields["expedition_date"] = $f->get_FieldView("expedition_date", array("value" => $r["expedition_date"], "proportion" => "col-xl-6 col-md-6 col-12", "required" => true));
$f->fields["expedition_place"] = $f->get_FieldView("expedition_place", array("value" => $r["expedition_place"], "proportion" => "col-xl-6 col-md-6 col-12"));

$f->fields["sie-registration"] = $f->get_FieldView("sie-registration", array("value" => $r["sie-registration"], "proportion" => "col-xl-6 col-md-6 col-12"));

$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => "/security/users/list/" . lpk(), "text" => lang("App.Continue"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left disabled"));
//[groups]--------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("fields" => $f->fields["alias"] . $f->fields["password"] . $f->fields["confirm"]));
$f->groups["g2"] = $f->get_Group(array("fields" => $f->fields["firstname"] . $f->fields["lastname"]));
$f->groups["g3"] = $f->get_Group(array("fields" => $f->fields["address"]));
$f->groups["g4"] = $f->get_Group(array("fields" => $f->fields["email"] . $f->fields["phone"]));
$f->groups["g5"] = $f->get_Group(array("fields" => $f->fields["birthday"] . $f->fields["citizenshipcard"]));
$f->groups["g6"] = $f->get_Group(array("fields" => $f->fields["expedition_date"] . $f->fields["expedition_place"]));
$f->groups["g7"] = $f->get_Group(array("fields" => $f->fields["reference"]));
$f->groups["g8"] = $f->get_Group(array("fields" => $f->fields["notes"]));
$f->groups["g9"] = $f->get_Group(array("fields" => $f->fields["sie-registration"]));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["cancel"]));
//+[Logger]------------------------------------------------------------------------------------------------------------
$hl_alias= safe_strtolower($r["alias"]);
history_logger(array(
    "module" => "SECURITY",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "USERS-VIEW",
    "log" => "El usuario accede al perfil de <a href=\"/security/users/view/".$oid."\" target=\"_blank\">@".$hl_alias."</a>",
));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => sprintf(lang("Users.view-title"), $oid),
    "header-back" => $back,
    "header-edit" => "/security/users/edit/". $oid,
    "content" => $f,
));
echo($card);
?>