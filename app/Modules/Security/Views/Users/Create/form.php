<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2023-12-20 13:01:35
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Security\Views\Users\Creator\form.php]
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
$b = service("bootstrap");
$f = service("forms", array("lang" => "Users."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Security\Models\Security_Users");
//[vars]----------------------------------------------------------------------------------------------------------------
$r["user"] = $f->get_Value("user", pk());
$r["alias"] = $f->get_Value("alias");
$r["birthday"] = $f->get_Value("birthday");
$r["citizenshipcard"] = $f->get_Value("citizenshipcard");
$r["email"] = $f->get_Value("email");
$r["firstname"] = $f->get_Value("firstname");
$r["lastname"] = $f->get_Value("lastname");
$r["password"] = $f->get_Value("password");
$r["confirm"] = $f->get_Value("confirm");
$r["phone"] = $f->get_Value("phone");
$r["address"] = $f->get_Value("address");
$r["reference"] = $f->get_Value("reference");
$r["notes"] = $f->get_Value("notes");
$r["expedition_date"] = $f->get_Value("expedition_date");
$r["expedition_place"] = $f->get_Value("expedition_place");
$r["author"] = safe_get_User();
$back = "/security/users/list/" . lpk();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("user", $r["user"]);
$f->add_HiddenField("author", $r["author"]);
$f->fields["alias"] = $f->get_FieldAlias("alias", array("value" => $r["alias"], "proportion" => "col-xl-4 col-md-12 col-12"));
$f->fields["birthday"] = $f->get_FieldDate("birthday", array("value" => $r["birthday"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["citizenshipcard"] = $f->get_FieldCitizenShipcard("citizenshipcard", array("value" => $r["citizenshipcard"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["password"] = $f->get_FieldPassword("password", array("value" => $r["password"], "proportion" => "col-xl-4 col-md-12 col-12"));
$f->fields["confirm"] = $f->get_FieldPassword("confirm", array("value" => $r["confirm"], "proportion" => "col-xl-4 col-md-12 col-12"));
$f->fields["email"] = $f->get_FieldEmail("email", array("value" => $r["email"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["firstname"] = $f->get_FieldText("firstname", array("value" => $r["firstname"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["lastname"] = $f->get_FieldText("lastname", array("value" => $r["lastname"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["phone"] = $f->get_FieldText("phone", array("value" => $r["phone"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["address"] = $f->get_FieldText("address", array("value" => $r["address"], "proportion" => "col-xl-12 col-md-12 col-12"));
$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"], "proportion" => "col-xl-12 col-md-12 col-12"));
$f->fields["notes"] = $f->get_FieldTextArea("notes", array("value" => $r["notes"], "proportion" => "col-xl-12 col-md-12 col-12"));
$f->fields["expedition_date"] = $f->get_FieldDate("expedition_date", array("value" => $r["expedition_date"], "proportion" => "col-xl-6 col-md-6 col-12", "required" => true));
$f->fields["expedition_place"] = $f->get_FieldText("expedition_place", array("value" => $r["expedition_place"], "proportion" => "col-xl-6 col-md-6 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Create"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("fields" => $f->fields["alias"] . $f->fields["password"] . $f->fields["confirm"]));
$f->groups["g2"] = $f->get_Group(array("fields" => $f->fields["firstname"] . $f->fields["lastname"]));
$f->groups["g3"] = $f->get_Group(array("fields" => $f->fields["address"]));
$f->groups["g4"] = $f->get_Group(array("fields" => $f->fields["email"] . $f->fields["phone"]));
$f->groups["g5"] = $f->get_Group(array("fields" => $f->fields["birthday"] . $f->fields["citizenshipcard"]));
$f->groups["g6"] = $f->get_Group(array("fields" => $f->fields["expedition_date"] . $f->fields["expedition_place"]));
$f->groups["g7"] = $f->get_Group(array("fields" => $f->fields["reference"]));
$f->groups["g8"] = $f->get_Group(array("fields" => $f->fields["notes"]));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card("create", array(
    "title" => lang("Security.create-title"),
    "content" => $f,
));
echo($card);
?>