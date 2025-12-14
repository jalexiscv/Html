<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-09-14 22:39:42
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Patients\Editor\processor.php]
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
* █ @link https://www.higgs.com.co
* █ @Version 1.5.1 @since PHP 8,PHP 9
* █ ---------------------------------------------------------------------------------------------------------------------
**/
//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication =service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
$model = model("App\Modules\Iris\Models\Iris_Patients");
//[Process]-----------------------------------------------------------------------------
$f = service("forms",array("lang" => "Iris_Patients."));

$first_name = safe_strtoupper($f->get_Value("first_name"));
$middle_name = safe_strtoupper($f->get_Value("middle_name"));
$first_surname = safe_strtoupper($f->get_Value("first_surname"));
$second_surname = safe_strtoupper($f->get_Value("second_surname"));

// Forma eficiente de construir el nombre completo, omitiendo partes vacías.
$name_parts = array_filter([$first_name, $middle_name, $first_surname, $second_surname]);
$full_name = implode(' ', $name_parts);

$d = array(
    "patient" => $f->get_Value("patient"),
    "fhir_id" => $f->get_Value("fhir_id"),
    "active" => $f->get_Value("active"),
    "document_type" => $f->get_Value("document_type"),
    "document_number" => $f->get_Value("document_number"),
    "document_issued_place" => $f->get_Value("document_issued_place"),
    "first_name" => $first_name,
    "middle_name" => $middle_name,
    "first_surname" => $first_surname,
    "second_surname" => $second_surname,
    "full_name" => $full_name,
    "gender" => $f->get_Value("gender"),
    "birth_date" => $f->get_Value("birth_date"),
    "birth_place" => $f->get_Value("birth_place"),
    "marital_status" => $f->get_Value("marital_status"),
    "primary_phone" => $f->get_Value("primary_phone"),
    "secondary_phone" => $f->get_Value("secondary_phone"),
    "email" => $f->get_Value("email"),
    "full_address" => $f->get_Value("full_address"),
    "neighborhood" => $f->get_Value("neighborhood"),
    "city" => $f->get_Value("city"),
    "state" => $f->get_Value("state"),
    "postal_code" => $f->get_Value("postal_code"),
    "country" => $f->get_Value("country"),
    "residence_area" => $f->get_Value("residence_area"),
    "socioeconomic_stratum" => $f->get_Value("socioeconomic_stratum"),
    "emergency_contact_name" => $f->get_Value("emergency_contact_name"),
    "emergency_contact_relationship" => $f->get_Value("emergency_contact_relationship"),
    "emergency_contact_phone" => $f->get_Value("emergency_contact_phone"),
    "health_insurance" => $f->get_Value("health_insurance"),
    "health_regime" => $f->get_Value("health_regime"),
    "affiliation_type" => $f->get_Value("affiliation_type"),
    "ethnicity" => $f->get_Value("ethnicity"),
    "special_population" => $f->get_Value("special_population"),
    "has_diabetes" => $f->get_Value("has_diabetes"),
    "has_hypertension" => $f->get_Value("has_hypertension"),
    "family_history_glaucoma" => $f->get_Value("family_history_glaucoma"),
    "family_history_diabetes" => $f->get_Value("family_history_diabetes"),
    "family_history_retinopathy" => $f->get_Value("family_history_retinopathy"),
    "previous_eye_surgeries" => $f->get_Value("previous_eye_surgeries"),
    "blood_type" => $f->get_Value("blood_type"),
    "allergies" => $f->get_Value("allergies"),
    "current_medications" => $f->get_Value("current_medications"),
    "primary_language" => $f->get_Value("primary_language"),
    "data_consent" => $f->get_Value("data_consent"),
    "accepts_communications" => $f->get_Value("accepts_communications"),
    "profile_photo" => $f->get_Value("profile_photo"),
    "observations" => $f->get_Value("observations"),
    "created_by" => $f->get_Value("created_by"),
    "updated_by" => $f->get_Value("updated_by"),
    "deleted_by" => $f->get_Value("deleted_by"),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["patient"]);
$l["back"]=$f->get_Value("back");
$l["edit"]="/iris/patients/edit/{$d["patient"]}";
$asuccess = "iris/patients-edit-success-message.mp3";
$anoexist = "iris/patients-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
   $edit = $model->update($d['patient'],$d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Iris_Patients.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Iris_Patients.edit-success-message"),
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
        "title" => lang("Iris_Patients.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Iris_Patients.edit-noexist-message"),$d['patient']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
cache()->clean();
?>
