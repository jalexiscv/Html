<?php

/** @var TYPE_NAME $model */
/** @var TYPE_NAME $oid */

//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sie\Models\Sie_Registrations");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Registrations."));
$d = array(
    "registration" => $f->get_Value("registration"),
    "country" => $f->get_Value("country"),
    "region" => $f->get_Value("region"),
    "city" => $f->get_Value("city"),
    "agreement" => $f->get_Value("agreement"),
    "agreement_country" => $f->get_Value("agreement_country"),
    "agreement_region" => $f->get_Value("agreement_region"),
    "agreement_city" => $f->get_Value("agreement_city"),
    "agreement_institution" => $f->get_Value("agreement_institution"),
    "agreement_group" => $f->get_Value("agreement_group"),
    "campus" => $f->get_Value("campus"),
    "shifts" => $f->get_Value("shifts"),
    "group" => $f->get_Value("group"),
    "period" => $f->get_Value("period"),
    "journey" => $f->get_Value("journey"),
    "program" => $f->get_Value("program"),
    "first_name" => safe_strtoupper($f->get_Value("first_name")),
    "second_name" => safe_strtoupper($f->get_Value("second_name")),
    "first_surname" => safe_strtoupper($f->get_Value("first_surname")),
    "second_surname" => safe_strtoupper($f->get_Value("second_surname")),
    "identification_type" => $f->get_Value("identification_type"),
    "identification_number" => $f->get_Value("identification_number"),
    //"identification_place" => $f->get_Value("identification_place"),
    "identification_date" => $f->get_Value("identification_date"),
    "identification_country" => $f->get_Value("identification_country"),
    "identification_region" => $f->get_Value("identification_region"),
    "identification_city" => $f->get_Value("identification_city"),

    "gender" => $f->get_Value("gender"),
    "email_address" => safe_strtoupper($f->get_Value("email_address")),
    "email_institutional" => safe_strtoupper($f->get_Value("email_institutional")),
    "phone" => $f->get_Value("phone"),
    "mobile" => $f->get_Value("mobile"),
    "birth_date" => $f->get_Value("birth_date"),
    "birth_country" => $f->get_Value("birth_country"),
    "birth_region" => $f->get_Value("birth_region"),
    "birth_city" => $f->get_Value("birth_city"),
    "address" => safe_strtoupper($f->get_Value("address")),
    "residence_country" => $f->get_Value("residence_country"),
    "residence_region" => $f->get_Value("residence_region"),
    "residence_city" => $f->get_Value("residence_city"),
    "neighborhood" => safe_strtoupper($f->get_Value("neighborhood")),
    "area" => $f->get_Value("area"),
    "stratum" => $f->get_Value("stratum"),
    "transport_method" => $f->get_Value("transport_method"),
    "sisben_group" => $f->get_Value("sisben_group"),
    "sisben_subgroup" => $f->get_Value("sisben_subgroup"),
    "document_issue_place" => $f->get_Value("document_issue_place"),
    "blood_type" => $f->get_Value("blood_type"),
    "marital_status" => $f->get_Value("marital_status"),
    "number_children" => $f->get_Value("number_children"),
    "military_card" => $f->get_Value("military_card"),
    //"ars" => $f->get_Value("ars"),
    //"insurer" => $f->get_Value("insurer"),
    "eps" => $f->get_Value("eps"),
    "education_level" => $f->get_Value("education_level"),
    "occupation" => $f->get_Value("occupation"),
    "health_regime" => $f->get_Value("health_regime"),
    "document_issue_date" => $f->get_Value("document_issue_date"),
    "saber11" => $f->get_Value("saber11"),
    "saber11_value" => $f->get_Value("saber11_value"),
    "saber11_date" => $f->get_Value("saber11_date"),
    "graduation_certificate" => $f->get_Value("graduation_certificate"),
    "military_id" => $f->get_Value("military_id"),
    "diploma" => $f->get_Value("diploma"),
    "icfes_certificate" => $f->get_Value("icfes_certificate"),
    "utility_bill" => $f->get_Value("utility_bill"),
    "sisben_certificate" => $f->get_Value("sisben_certificate"),
    "address_certificate" => $f->get_Value("address_certificate"),
    "electoral_certificate" => $f->get_Value("electoral_certificate"),
    "photo_card" => $f->get_Value("photo_card"),
    "observations" => $f->get_Value("observations"),
    //"status" => $f->get_Value("status"),
    "author" => safe_get_user(),
    "ticket" => $f->get_Value("ticket"),
    "interview" => $f->get_Value("interview"),
    "linkage_type" => $f->get_Value("linkage_type"),
    "indigenous_people" => $f->get_Value("indigenous_people"),
    "afro_descendant" => $f->get_Value("afro_descendant"),
    "disability" => $f->get_Value("disability"),
    "disability_type" => $f->get_Value("disability_type"),
    "exceptional_ability" => $f->get_Value("exceptional_ability"),
    "responsible" => $f->get_Value("responsible"),
    "responsible_relationship" => $f->get_Value("responsible_relationship"),


    "responsible_phone" => $f->get_Value("responsible_phone"),

    "observations_academic" => $f->get_Value("observations_academic"),
    //"import" => $f->get_Value("import"),
    "moment" => $f->get_Value("moment"),
    "snies_updated_at" => $f->get_Value("snies_updated_at"),
    "photo" => $f->get_Value("photo"),
    "college" => safe_strtoupper($f->get_Value("college")),
    "college_year" => $f->get_Value("college_year"),
    "ac" => $f->get_Value("ac"),
    "ac_score" => $f->get_Value("ac_score"),
    "ac_date" => $f->get_Value("ac_date"),
    "ac_document_type" => $f->get_Value("ac_document_type"),
    "ac_document_number" => $f->get_Value("ac_document_number"),
    "ek" => $f->get_Value("ek"),
    "ek_score" => $f->get_Value("ek_score"),
    "snies_id_validation_requisite" => $f->get_Value("snies_id_validation_requisite"),
    //3.1. Información familiar
    "num_people_living_with_you" => $f->get_Value("num_people_living_with_you"),
    "num_people_contributing_economically" => $f->get_Value("num_people_contributing_economically"),
    "num_people_depending_on_you" => $f->get_Value("num_people_depending_on_you"),
    "education_level_father" => $f->get_Value("education_level_father"),
    "education_level_mother" => $f->get_Value("education_level_mother"),
    "type_of_housing" => $f->get_Value("type_of_housing"),
    //4. Información Laboral
    "economic_dependency" => $f->get_Value("economic_dependency"),
    "type_of_funding" => $f->get_Value("type_of_funding"),
    "current_occupation" => $f->get_Value("current_occupation"),
    "type_of_work" => $f->get_Value("type_of_work"),
    "weekly_hours_worked" => $f->get_Value("weekly_hours_worked"),
    "monthly_income" => $f->get_Value("monthly_income"),
    "company_name" => $f->get_Value("company_name"),
    "company_position" => $f->get_Value("company_position"),
    "productive_sector" => $f->get_Value("productive_sector"),
    //5. Información adicional
    "first_in_family_to_study_university" => $f->get_Value("first_in_family_to_study_university"),
    "border_population" => $f->get_Value("border_population"),
    "identified_population_group" => $f->get_Value("identified_population_group"),
    "highlighted_population" => $f->get_Value("highlighted_population"),
    "ethnic_group" => $f->get_Value("ethnic_group"),
);
//[Elements]-----------------------------------------------------------------------------

$row = $model->find($d["registration"]);


$l["back"] = "/sie/students/view/{$oid}";
$l["edit"] = "/sie/registrations/edit/{$d["registration"]}";
$asuccess = "sie/registrations-edit-success-message.mp3";
$anoexist = "sie/registrations-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------

//echo("<pre>");
//print_r($d);
//echo("</pre>");


if (is_array($row)) {
    $edit = $model->update($d['registration'], $d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Registrations.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Registrations.edit-success-message"),
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
        "title" => lang("Sie_Registrations.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Registrations.edit-noexist-message"), $d['registration']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
?>