<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-15 22:17:33
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
//[services]------------------------------------------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$f = service("forms", array("lang" => "Q10profiles."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Q10profiles");
//[vars]----------------------------------------------------------------------------------------------------------------
// @var string view cadena que se pasa a la vista definida en viewer para su evaluación
// @var string views Uri completa hasta las vistas de modulo.
// @var string viewer URI completa hasta la vista encargada de evaluar cada view solicitado.
// @var string component URI completa hasta el componente solicitado.
// @var string oid valor de objeto recibido generalmente objeto / dato a visualizar
// @var string authentication  el servicio de autenticación desde el ModuleController
// @var string dates el servicio de fechas desde el ModuleController
// @var string strings el servicio de cadenas desde el ModuleController
// @var string request el servicio de solicitud desde el ModuleController
$row = $model->get_Q10profiles($oid);
$r["profile"] = $f->get_Value("profile", $row["profile"]);
$r["first_name"] = $f->get_Value("first_name", $row["first_name"]);
$r["last_name"] = $f->get_Value("last_name", $row["last_name"]);
$r["id_number"] = $f->get_Value("id_number", $row["id_number"]);
$r["phone"] = $f->get_Value("phone", $row["phone"]);
$r["mobile_phone"] = $f->get_Value("mobile_phone", $row["mobile_phone"]);
$r["email"] = $f->get_Value("email", $row["email"]);
$r["residence_location"] = $f->get_Value("residence_location", $row["residence_location"]);
$r["birth_date"] = $f->get_Value("birth_date", $row["birth_date"]);
$r["blood_type"] = $f->get_Value("blood_type", $row["blood_type"]);
$r["campus_shift"] = $f->get_Value("campus_shift", $row["campus_shift"]);
$r["address"] = $f->get_Value("address", $row["address"]);
$r["neighborhood"] = $f->get_Value("neighborhood", $row["neighborhood"]);
$r["birth_place"] = $f->get_Value("birth_place", $row["birth_place"]);
$r["registration_date"] = $f->get_Value("registration_date", $row["registration_date"]);
$r["program"] = $f->get_Value("program", $row["program"]);
$r["health_provider"] = $f->get_Value("health_provider", $row["health_provider"]);
$r["ars_provider"] = $f->get_Value("ars_provider", $row["ars_provider"]);
$r["insurance_provider"] = $f->get_Value("insurance_provider", $row["insurance_provider"]);
$r["civil_status"] = $f->get_Value("civil_status", $row["civil_status"]);
$r["education_level"] = $f->get_Value("education_level", $row["education_level"]);
$r["institution"] = $f->get_Value("institution", $row["institution"]);
$r["municipality"] = $f->get_Value("municipality", $row["municipality"]);
$r["academic_level"] = $f->get_Value("academic_level", $row["academic_level"]);
$r["graduated"] = $f->get_Value("graduated", $row["graduated"]);
$r["degree_earned"] = $f->get_Value("degree_earned", $row["degree_earned"]);
$r["graduation_date"] = $f->get_Value("graduation_date", $row["graduation_date"]);
$r["family_member_full_name"] = $f->get_Value("family_member_full_name", $row["family_member_full_name"]);
$r["family_member_id_number"] = $f->get_Value("family_member_id_number", $row["family_member_id_number"]);
$r["family_member_phone"] = $f->get_Value("family_member_phone", $row["family_member_phone"]);
$r["family_member_mobile_phone"] = $f->get_Value("family_member_mobile_phone", $row["family_member_mobile_phone"]);
$r["family_member_email"] = $f->get_Value("family_member_email", $row["family_member_email"]);
$r["family_relationship"] = $f->get_Value("family_relationship", $row["family_relationship"]);
$r["company"] = $f->get_Value("company", $row["company"]);
$r["company_municipality"] = $f->get_Value("company_municipality", $row["company_municipality"]);
$r["job_position"] = $f->get_Value("job_position", $row["job_position"]);
$r["company_phone"] = $f->get_Value("company_phone", $row["company_phone"]);
$r["company_address"] = $f->get_Value("company_address", $row["company_address"]);
$r["job_start_date"] = $f->get_Value("job_start_date", $row["job_start_date"]);
$r["job_end_date"] = $f->get_Value("job_end_date", $row["job_end_date"]);
$r["source"] = $f->get_Value("source", $row["source"]);
$r["print_date"] = $f->get_Value("print_date", $row["print_date"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = "/sie/q10profiles/list/" . lpk();
//[fields]----------------------------------------------------------------------------------------------------------------
$f->fields["profile"] = $f->get_FieldText("profile", array("value" => $r["profile"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["first_name"] = $f->get_FieldText("first_name", array("value" => $r["first_name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["last_name"] = $f->get_FieldText("last_name", array("value" => $r["last_name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["id_number"] = $f->get_FieldText("id_number", array("value" => $r["id_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["phone"] = $f->get_FieldText("phone", array("value" => $r["phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["mobile_phone"] = $f->get_FieldText("mobile_phone", array("value" => $r["mobile_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email"] = $f->get_FieldText("email", array("value" => $r["email"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["residence_location"] = $f->get_FieldText("residence_location", array("value" => $r["residence_location"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["birth_date"] = $f->get_FieldText("birth_date", array("value" => $r["birth_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["blood_type"] = $f->get_FieldText("blood_type", array("value" => $r["blood_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["campus_shift"] = $f->get_FieldText("campus_shift", array("value" => $r["campus_shift"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["address"] = $f->get_FieldText("address", array("value" => $r["address"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["neighborhood"] = $f->get_FieldText("neighborhood", array("value" => $r["neighborhood"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["birth_place"] = $f->get_FieldText("birth_place", array("value" => $r["birth_place"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["registration_date"] = $f->get_FieldText("registration_date", array("value" => $r["registration_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["program"] = $f->get_FieldText("program", array("value" => $r["program"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["health_provider"] = $f->get_FieldText("health_provider", array("value" => $r["health_provider"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ars_provider"] = $f->get_FieldText("ars_provider", array("value" => $r["ars_provider"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["insurance_provider"] = $f->get_FieldText("insurance_provider", array("value" => $r["insurance_provider"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["civil_status"] = $f->get_FieldText("civil_status", array("value" => $r["civil_status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["education_level"] = $f->get_FieldText("education_level", array("value" => $r["education_level"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["institution"] = $f->get_FieldText("institution", array("value" => $r["institution"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["municipality"] = $f->get_FieldText("municipality", array("value" => $r["municipality"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["academic_level"] = $f->get_FieldText("academic_level", array("value" => $r["academic_level"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["graduated"] = $f->get_FieldText("graduated", array("value" => $r["graduated"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["degree_earned"] = $f->get_FieldText("degree_earned", array("value" => $r["degree_earned"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["graduation_date"] = $f->get_FieldText("graduation_date", array("value" => $r["graduation_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_member_full_name"] = $f->get_FieldText("family_member_full_name", array("value" => $r["family_member_full_name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_member_id_number"] = $f->get_FieldText("family_member_id_number", array("value" => $r["family_member_id_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_member_phone"] = $f->get_FieldText("family_member_phone", array("value" => $r["family_member_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_member_mobile_phone"] = $f->get_FieldText("family_member_mobile_phone", array("value" => $r["family_member_mobile_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_member_email"] = $f->get_FieldText("family_member_email", array("value" => $r["family_member_email"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_relationship"] = $f->get_FieldText("family_relationship", array("value" => $r["family_relationship"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["company"] = $f->get_FieldText("company", array("value" => $r["company"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["company_municipality"] = $f->get_FieldText("company_municipality", array("value" => $r["company_municipality"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["job_position"] = $f->get_FieldText("job_position", array("value" => $r["job_position"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["company_phone"] = $f->get_FieldText("company_phone", array("value" => $r["company_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["company_address"] = $f->get_FieldText("company_address", array("value" => $r["company_address"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["job_start_date"] = $f->get_FieldText("job_start_date", array("value" => $r["job_start_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["job_end_date"] = $f->get_FieldText("job_end_date", array("value" => $r["job_end_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["source"] = $f->get_FieldText("source", array("value" => $r["source"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["print_date"] = $f->get_FieldText("print_date", array("value" => $r["print_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
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
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => lang("Q10profiles.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
