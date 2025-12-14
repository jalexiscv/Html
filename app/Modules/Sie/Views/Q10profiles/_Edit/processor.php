<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-15 22:17:33
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Q10profiles\Editor\processor.php]
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Q10profiles");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Q10profiles."));
$d = array(
    "profile" => $f->get_Value("profile"),
    "first_name" => $f->get_Value("first_name"),
    "last_name" => $f->get_Value("last_name"),
    "id_number" => $f->get_Value("id_number"),
    "phone" => $f->get_Value("phone"),
    "mobile_phone" => $f->get_Value("mobile_phone"),
    "email" => $f->get_Value("email"),
    "residence_location" => $f->get_Value("residence_location"),
    "birth_date" => $f->get_Value("birth_date"),
    "blood_type" => $f->get_Value("blood_type"),
    "campus_shift" => $f->get_Value("campus_shift"),
    "address" => $f->get_Value("address"),
    "neighborhood" => $f->get_Value("neighborhood"),
    "birth_place" => $f->get_Value("birth_place"),
    "registration_date" => $f->get_Value("registration_date"),
    "program" => $f->get_Value("program"),
    "health_provider" => $f->get_Value("health_provider"),
    "ars_provider" => $f->get_Value("ars_provider"),
    "insurance_provider" => $f->get_Value("insurance_provider"),
    "civil_status" => $f->get_Value("civil_status"),
    "education_level" => $f->get_Value("education_level"),
    "institution" => $f->get_Value("institution"),
    "municipality" => $f->get_Value("municipality"),
    "academic_level" => $f->get_Value("academic_level"),
    "graduated" => $f->get_Value("graduated"),
    "degree_earned" => $f->get_Value("degree_earned"),
    "graduation_date" => $f->get_Value("graduation_date"),
    "family_member_full_name" => $f->get_Value("family_member_full_name"),
    "family_member_id_number" => $f->get_Value("family_member_id_number"),
    "family_member_phone" => $f->get_Value("family_member_phone"),
    "family_member_mobile_phone" => $f->get_Value("family_member_mobile_phone"),
    "family_member_email" => $f->get_Value("family_member_email"),
    "family_relationship" => $f->get_Value("family_relationship"),
    "company" => $f->get_Value("company"),
    "company_municipality" => $f->get_Value("company_municipality"),
    "job_position" => $f->get_Value("job_position"),
    "company_phone" => $f->get_Value("company_phone"),
    "company_address" => $f->get_Value("company_address"),
    "job_start_date" => $f->get_Value("job_start_date"),
    "job_end_date" => $f->get_Value("job_end_date"),
    "source" => $f->get_Value("source"),
    "print_date" => $f->get_Value("print_date"),
    "author" => safe_get_user(),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["profile"]);
$l["back"] = "/sie/q10profiles/list/" . lpk();
$l["edit"] = "/sie/q10profiles/edit/{$d["profile"]}";
$asuccess = "sie/q10profiles-edit-success-message.mp3";
$anoexist = "sie/q10profiles-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $model->update($d['profile'], $d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Q10profiles.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Q10profiles.edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Q10profiles.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Q10profiles.edit-noexist-message"), $d['profile']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>
