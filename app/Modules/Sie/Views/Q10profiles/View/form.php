<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-15 22:17:31
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Q10profiles\Editor\form.php]
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
$f = service("forms", array("lang" => "Q10profiles."));
//[Request]-----------------------------------------------------------------------------
$row = $model->get_Q10profiles($oid);
$r["profile"] = $row["profile"];
$r["first_name"] = $row["first_name"];
$r["last_name"] = $row["last_name"];
$r["id_number"] = $row["id_number"];
$r["phone"] = $row["phone"];
$r["mobile_phone"] = $row["mobile_phone"];
$r["email"] = $row["email"];
$r["residence_location"] = $row["residence_location"];
$r["birth_date"] = $row["birth_date"];
$r["blood_type"] = $row["blood_type"];
$r["campus_shift"] = $row["campus_shift"];
$r["address"] = $row["address"];
$r["neighborhood"] = $row["neighborhood"];
$r["birth_place"] = $row["birth_place"];
$r["registration_date"] = $row["registration_date"];
$r["program"] = $row["program"];
$r["health_provider"] = $row["health_provider"];
$r["ars_provider"] = $row["ars_provider"];
$r["insurance_provider"] = $row["insurance_provider"];
$r["civil_status"] = $row["civil_status"];
$r["education_level"] = $row["education_level"];
$r["institution"] = $row["institution"];
$r["municipality"] = $row["municipality"];
$r["academic_level"] = $row["academic_level"];
$r["graduated"] = $row["graduated"];
$r["degree_earned"] = $row["degree_earned"];
$r["graduation_date"] = $row["graduation_date"];
$r["family_member_full_name"] = $row["family_member_full_name"];
$r["family_member_id_number"] = $row["family_member_id_number"];
$r["family_member_phone"] = $row["family_member_phone"];
$r["family_member_mobile_phone"] = $row["family_member_mobile_phone"];
$r["family_member_email"] = $row["family_member_email"];
$r["family_relationship"] = $row["family_relationship"];
$r["company"] = $row["company"];
$r["company_municipality"] = $row["company_municipality"];
$r["job_position"] = $row["job_position"];
$r["company_phone"] = $row["company_phone"];
$r["company_address"] = $row["company_address"];
$r["job_start_date"] = $row["job_start_date"];
$r["job_end_date"] = $row["job_end_date"];
$r["source"] = $row["source"];
$r["print_date"] = $row["print_date"];
$r["author"] = $row["author"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];
$back = "/sie/q10profiles/list/" . lpk();
//[Fields]-----------------------------------------------------------------------------
$f->fields["profile"] = $f->get_FieldView("profile", array("value" => $r["profile"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["first_name"] = $f->get_FieldView("first_name", array("value" => $r["first_name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["last_name"] = $f->get_FieldView("last_name", array("value" => $r["last_name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["id_number"] = $f->get_FieldView("id_number", array("value" => $r["id_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["phone"] = $f->get_FieldView("phone", array("value" => $r["phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["mobile_phone"] = $f->get_FieldView("mobile_phone", array("value" => $r["mobile_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email"] = $f->get_FieldView("email", array("value" => $r["email"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["residence_location"] = $f->get_FieldView("residence_location", array("value" => $r["residence_location"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["birth_date"] = $f->get_FieldView("birth_date", array("value" => $r["birth_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["blood_type"] = $f->get_FieldView("blood_type", array("value" => $r["blood_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["campus_shift"] = $f->get_FieldView("campus_shift", array("value" => $r["campus_shift"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["address"] = $f->get_FieldView("address", array("value" => $r["address"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["neighborhood"] = $f->get_FieldView("neighborhood", array("value" => $r["neighborhood"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["birth_place"] = $f->get_FieldView("birth_place", array("value" => $r["birth_place"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["registration_date"] = $f->get_FieldView("registration_date", array("value" => $r["registration_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["program"] = $f->get_FieldView("program", array("value" => $r["program"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["health_provider"] = $f->get_FieldView("health_provider", array("value" => $r["health_provider"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ars_provider"] = $f->get_FieldView("ars_provider", array("value" => $r["ars_provider"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["insurance_provider"] = $f->get_FieldView("insurance_provider", array("value" => $r["insurance_provider"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["civil_status"] = $f->get_FieldView("civil_status", array("value" => $r["civil_status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["education_level"] = $f->get_FieldView("education_level", array("value" => $r["education_level"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["institution"] = $f->get_FieldView("institution", array("value" => $r["institution"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["municipality"] = $f->get_FieldView("municipality", array("value" => $r["municipality"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["academic_level"] = $f->get_FieldView("academic_level", array("value" => $r["academic_level"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["graduated"] = $f->get_FieldView("graduated", array("value" => $r["graduated"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["degree_earned"] = $f->get_FieldView("degree_earned", array("value" => $r["degree_earned"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["graduation_date"] = $f->get_FieldView("graduation_date", array("value" => $r["graduation_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_member_full_name"] = $f->get_FieldView("family_member_full_name", array("value" => $r["family_member_full_name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_member_id_number"] = $f->get_FieldView("family_member_id_number", array("value" => $r["family_member_id_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_member_phone"] = $f->get_FieldView("family_member_phone", array("value" => $r["family_member_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_member_mobile_phone"] = $f->get_FieldView("family_member_mobile_phone", array("value" => $r["family_member_mobile_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_member_email"] = $f->get_FieldView("family_member_email", array("value" => $r["family_member_email"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_relationship"] = $f->get_FieldView("family_relationship", array("value" => $r["family_relationship"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["company"] = $f->get_FieldView("company", array("value" => $r["company"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["company_municipality"] = $f->get_FieldView("company_municipality", array("value" => $r["company_municipality"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["job_position"] = $f->get_FieldView("job_position", array("value" => $r["job_position"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["company_phone"] = $f->get_FieldView("company_phone", array("value" => $r["company_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["company_address"] = $f->get_FieldView("company_address", array("value" => $r["company_address"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["job_start_date"] = $f->get_FieldView("job_start_date", array("value" => $r["job_start_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["job_end_date"] = $f->get_FieldView("job_end_date", array("value" => $r["job_end_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["source"] = $f->get_FieldView("source", array("value" => $r["source"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["print_date"] = $f->get_FieldView("print_date", array("value" => $r["print_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/sie/q10profiles/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["profile"] . $f->fields["first_name"] . $f->fields["last_name"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["id_number"] . $f->fields["phone"] . $f->fields["mobile_phone"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["email"] . $f->fields["residence_location"] . $f->fields["birth_date"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["blood_type"] . $f->fields["campus_shift"] . $f->fields["address"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["neighborhood"] . $f->fields["birth_place"] . $f->fields["registration_date"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["program"] . $f->fields["health_provider"] . $f->fields["ars_provider"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["insurance_provider"] . $f->fields["civil_status"] . $f->fields["education_level"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["institution"] . $f->fields["municipality"] . $f->fields["academic_level"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["graduated"] . $f->fields["degree_earned"] . $f->fields["graduation_date"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["family_member_full_name"] . $f->fields["family_member_id_number"] . $f->fields["family_member_phone"])));
$f->groups["g11"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["family_member_mobile_phone"] . $f->fields["family_member_email"] . $f->fields["family_relationship"])));
$f->groups["g12"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["company"] . $f->fields["company_municipality"] . $f->fields["job_position"])));
$f->groups["g13"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["company_phone"] . $f->fields["company_address"] . $f->fields["job_start_date"])));
$f->groups["g14"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["job_end_date"] . $f->fields["source"] . $f->fields["print_date"])));
$f->groups["g15"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["author"] . $f->fields["created_at"] . $f->fields["updated_at"])));
$f->groups["g16"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["deleted_at"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang("Q10profiles.view-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>
