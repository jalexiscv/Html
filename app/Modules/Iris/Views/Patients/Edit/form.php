<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-09-14 23:04:43
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Patients\Editor\form.php]
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
//[services]------------------------------------------------------------------------------------------------------------
$b = service("bootstrap");
$f = service("forms", array("lang" => "Iris_Patients."));
$server = service("server");
//[models]--------------------------------------------------------------------------------------------------------------
$model = model("App\Modules\Iris\Models\Iris_Patients");
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->getPatient($oid);
$r["patient"] = $f->get_Value("patient", $row["patient"]);
$r["fhir_id"] = $f->get_Value("fhir_id", $row["fhir_id"]);
$r["active"] = $f->get_Value("active", $row["active"]);
$r["document_type"] = $f->get_Value("document_type", $row["document_type"]);
$r["document_number"] = $f->get_Value("document_number", $row["document_number"]);
$r["document_issued_place"] = $f->get_Value("document_issued_place", $row["document_issued_place"]);
$r["first_name"] = $f->get_Value("first_name", $row["first_name"]);
$r["middle_name"] = $f->get_Value("middle_name", $row["middle_name"]);
$r["first_surname"] = $f->get_Value("first_surname", $row["first_surname"]);
$r["second_surname"] = $f->get_Value("second_surname", $row["second_surname"]);
$r["gender"] = $f->get_Value("gender", $row["gender"]);
$r["birth_date"] = $f->get_Value("birth_date", $row["birth_date"]);
$r["birth_place"] = $f->get_Value("birth_place", $row["birth_place"]);
$r["marital_status"] = $f->get_Value("marital_status", $row["marital_status"]);
$r["primary_phone"] = $f->get_Value("primary_phone", $row["primary_phone"]);
$r["secondary_phone"] = $f->get_Value("secondary_phone", $row["secondary_phone"]);
$r["email"] = $f->get_Value("email", $row["email"]);
$r["full_address"] = $f->get_Value("full_address", $row["full_address"]);
$r["neighborhood"] = $f->get_Value("neighborhood", $row["neighborhood"]);
$r["city"] = $f->get_Value("city", $row["city"]);
$r["state"] = $f->get_Value("state", $row["state"]);
$r["postal_code"] = $f->get_Value("postal_code", $row["postal_code"]);
$r["country"] = $f->get_Value("country", $row["country"]);
$r["residence_area"] = $f->get_Value("residence_area", $row["residence_area"]);
$r["socioeconomic_stratum"] = $f->get_Value("socioeconomic_stratum", $row["socioeconomic_stratum"]);
$r["emergency_contact_name"] = $f->get_Value("emergency_contact_name", $row["emergency_contact_name"]);
$r["emergency_contact_relationship"] = $f->get_Value("emergency_contact_relationship", $row["emergency_contact_relationship"]);
$r["emergency_contact_phone"] = $f->get_Value("emergency_contact_phone", $row["emergency_contact_phone"]);
$r["health_insurance"] = $f->get_Value("health_insurance", $row["health_insurance"]);
$r["health_regime"] = $f->get_Value("health_regime", $row["health_regime"]);
$r["affiliation_type"] = $f->get_Value("affiliation_type", $row["affiliation_type"]);
$r["ethnicity"] = $f->get_Value("ethnicity", $row["ethnicity"]);
$r["special_population"] = $f->get_Value("special_population", $row["special_population"]);
$r["has_diabetes"] = $f->get_Value("has_diabetes", $row["has_diabetes"]);
$r["has_hypertension"] = $f->get_Value("has_hypertension", $row["has_hypertension"]);
$r["family_history_glaucoma"] = $f->get_Value("family_history_glaucoma", $row["family_history_glaucoma"]);
$r["family_history_diabetes"] = $f->get_Value("family_history_diabetes", $row["family_history_diabetes"]);
$r["family_history_retinopathy"] = $f->get_Value("family_history_retinopathy", $row["family_history_retinopathy"]);
$r["previous_eye_surgeries"] = $f->get_Value("previous_eye_surgeries", $row["previous_eye_surgeries"]);
$r["blood_type"] = $f->get_Value("blood_type", $row["blood_type"]);
$r["allergies"] = $f->get_Value("allergies", $row["allergies"]);
$r["current_medications"] = $f->get_Value("current_medications", $row["current_medications"]);
$r["primary_language"] = $f->get_Value("primary_language", $row["primary_language"]);
$r["data_consent"] = $f->get_Value("data_consent", $row["data_consent"]);
$r["accepts_communications"] = $f->get_Value("accepts_communications", $row["accepts_communications"]);
$r["profile_photo"] = $f->get_Value("profile_photo", $row["profile_photo"]);
$r["observations"] = $f->get_Value("observations", $row["observations"]);
$r["created_by"] = $f->get_Value("created_by", $row["created_by"]);
$r["updated_by"] = $f->get_Value("updated_by", $row["updated_by"]);
$r["deleted_by"] = $f->get_Value("deleted_by", $row["deleted_by"]);
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = $f->get_Value("back", $server->get_Referer());

$actives = array(array("value" => "", "label" => "Seleccione un valor"));
$document_types = array(array("value" => "", "label" => "Seleccione un valor"));
$genders = array(array("value" => "", "label" => "Seleccione un valor"));
$marital_statuses = array(array("value" => "", "label" => "Seleccione un valor"));
$residence_areas = array(array("value" => "", "label" => "Seleccione un valor"));
$health_regimes = array(array("value" => "", "label" => "Seleccione un valor"));
$affiliation_types = array(array("value" => "", "label" => "Seleccione un valor"));
$ethnicities = array(array("value" => "", "label" => "Seleccione un valor"));
$special_populations = array(array("value" => "", "label" => "Seleccione un valor"));
$blood_types = array(array("value" => "", "label" => "Seleccione un valor"));
$booleans = array(array("value" => "", "label" => "Seleccione un valor"));

$actives = array_merge($actives, IRIS_LIST_ACTIVE_STATUS);
$document_types = array_merge($document_types, IRIS_LIST_DOCUMENT_TYPE);
$genders = array_merge($genders, IRIS_LIST_GENDER);
$marital_statuses = array_merge($marital_statuses, IRIS_LIST_MARITAL_STATUS);
$residence_areas = array_merge($residence_areas, IRIS_LIST_RESIDENCE_AREA);
$health_regimes = array_merge($health_regimes, IRIS_LIST_HEALTH_REGIME);
$affiliation_types = array_merge($affiliation_types, IRIS_LIST_AFFILIATION_TYPE);
$ethnicities = array_merge($ethnicities, IRIS_LIST_ETHNICITY);
$special_populations = array_merge($special_populations, IRIS_LIST_SPECIAL_POPULATION);
$blood_types = array_merge($blood_types, IRIS_LIST_BLOOD_TYPE);
$booleans = array_merge($booleans, IRIS_LIST_BOOLEAN);

//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->add_HiddenField("patient", $r["patient"]);
$f->fields["patient"] = $f->get_FieldText("patient", array("value" => $r["patient"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["fhir_id"] = $f->get_FieldText("fhir_id", array("value" => $r["fhir_id"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["active"] = $f->get_FieldSelect("active", array("selected" => $r["active"], "data" => $actives, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_type"] = $f->get_FieldSelect("document_type", array("selected" => $r["document_type"], "data" => $document_types, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_number"] = $f->get_FieldText("document_number", array("value" => $r["document_number"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["document_issued_place"] = $f->get_FieldText("document_issued_place", array("value" => $r["document_issued_place"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["first_name"] = $f->get_FieldText("first_name", array("value" => $r["first_name"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["middle_name"] = $f->get_FieldText("middle_name", array("value" => $r["middle_name"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["first_surname"] = $f->get_FieldText("first_surname", array("value" => $r["first_surname"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["second_surname"] = $f->get_FieldText("second_surname", array("value" => $r["second_surname"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["gender"] = $f->get_FieldSelect("gender", array("selected" => $r["gender"], "data" => $genders, "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["birth_date"] = $f->get_FieldDate("birth_date", array("value" => $r["birth_date"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["birth_place"] = $f->get_FieldText("birth_place", array("value" => $r["birth_place"], "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["marital_status"] = $f->get_FieldSelect("marital_status", array("selected" => $r["marital_status"], "data" => $marital_statuses, "proportion" => "col-md-3 col-sm-12 col-12"));
$f->fields["primary_phone"] = $f->get_FieldText("primary_phone", array("value" => $r["primary_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["secondary_phone"] = $f->get_FieldText("secondary_phone", array("value" => $r["secondary_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email"] = $f->get_FieldText("email", array("value" => $r["email"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["full_address"] = $f->get_FieldText("full_address", array("value" => $r["full_address"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["neighborhood"] = $f->get_FieldText("neighborhood", array("value" => $r["neighborhood"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["city"] = $f->get_FieldText("city", array("value" => $r["city"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["state"] = $f->get_FieldText("state", array("value" => $r["state"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["postal_code"] = $f->get_FieldText("postal_code", array("value" => $r["postal_code"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["country"] = $f->get_FieldText("country", array("value" => $r["country"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["residence_area"] = $f->get_FieldSelect("residence_area", array("selected" => $r["residence_area"], "data" => $residence_areas, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["socioeconomic_stratum"] = $f->get_FieldText("socioeconomic_stratum", array("value" => $r["socioeconomic_stratum"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["emergency_contact_name"] = $f->get_FieldText("emergency_contact_name", array("value" => $r["emergency_contact_name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["emergency_contact_relationship"] = $f->get_FieldText("emergency_contact_relationship", array("value" => $r["emergency_contact_relationship"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["emergency_contact_phone"] = $f->get_FieldText("emergency_contact_phone", array("value" => $r["emergency_contact_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["health_insurance"] = $f->get_FieldText("health_insurance", array("value" => $r["health_insurance"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["health_regime"] = $f->get_FieldSelect("health_regime", array("selected" => $r["health_regime"], "data" => $health_regimes, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["affiliation_type"] = $f->get_FieldSelect("affiliation_type", array("selected" => $r["affiliation_type"], "data" => $affiliation_types, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ethnicity"] = $f->get_FieldSelect("ethnicity", array("selected" => $r["ethnicity"], "data" => $ethnicities, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["special_population"] = $f->get_FieldSelect("special_population", array("selected" => $r["special_population"], "data" => $special_populations, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["has_diabetes"] = $f->get_FieldSelect("has_diabetes", array("selected" => $r["has_diabetes"], "data" => $booleans, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["has_hypertension"] = $f->get_FieldSelect("has_hypertension", array("selected" => $r["has_hypertension"], "data" => $booleans, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_history_glaucoma"] = $f->get_FieldSelect("family_history_glaucoma", array("selected" => $r["family_history_glaucoma"], "data" => $booleans, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_history_diabetes"] = $f->get_FieldSelect("family_history_diabetes", array("selected" => $r["family_history_diabetes"], "data" => $booleans, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["family_history_retinopathy"] = $f->get_FieldSelect("family_history_retinopathy", array("selected" => $r["family_history_retinopathy"], "data" => $booleans, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["previous_eye_surgeries"] = $f->get_FieldText("previous_eye_surgeries", array("value" => $r["previous_eye_surgeries"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["blood_type"] = $f->get_FieldSelect("blood_type", array("selected" => $r["blood_type"], "data" => $blood_types, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["allergies"] = $f->get_FieldText("allergies", array("value" => $r["allergies"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["current_medications"] = $f->get_FieldText("current_medications", array("value" => $r["current_medications"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["primary_language"] = $f->get_FieldText("primary_language", array("value" => $r["primary_language"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["data_consent"] = $f->get_FieldSelect("data_consent", array("selected" => $r["data_consent"], "data" => $booleans, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["accepts_communications"] = $f->get_FieldSelect("accepts_communications", array("selected" => $r["accepts_communications"], "data" => $booleans, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["profile_photo"] = $f->get_FieldText("profile_photo", array("value" => $r["profile_photo"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["observations"] = $f->get_FieldText("observations", array("value" => $r["observations"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_by"] = $f->get_FieldText("created_by", array("value" => $r["created_by"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_by"] = $f->get_FieldText("updated_by", array("value" => $r["updated_by"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_by"] = $f->get_FieldText("deleted_by", array("value" => $r["deleted_by"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Save"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["patient"] . $f->fields["fhir_id"] . $f->fields["active"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["document_type"] . $f->fields["document_number"] . $f->fields["document_issued_place"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["first_name"] . $f->fields["middle_name"] . $f->fields["first_surname"] . $f->fields["second_surname"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["birth_date"] . $f->fields["birth_place"] . $f->fields["gender"] . $f->fields["marital_status"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["primary_phone"] . $f->fields["secondary_phone"] . $f->fields["email"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["full_address"] . $f->fields["neighborhood"] . $f->fields["city"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["state"] . $f->fields["postal_code"] . $f->fields["country"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["residence_area"] . $f->fields["socioeconomic_stratum"] . $f->fields["emergency_contact_name"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["emergency_contact_relationship"] . $f->fields["emergency_contact_phone"] . $f->fields["health_insurance"])));
$f->groups["g11"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["health_regime"] . $f->fields["affiliation_type"] . $f->fields["ethnicity"])));
$f->groups["g12"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["special_population"] . $f->fields["has_diabetes"] . $f->fields["has_hypertension"])));
$f->groups["g13"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["family_history_glaucoma"] . $f->fields["family_history_diabetes"] . $f->fields["family_history_retinopathy"])));
$f->groups["g14"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["previous_eye_surgeries"] . $f->fields["blood_type"] . $f->fields["allergies"])));
$f->groups["g15"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["current_medications"] . $f->fields["primary_language"] . $f->fields["data_consent"])));
$f->groups["g16"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["accepts_communications"] . $f->fields["profile_photo"] . $f->fields["observations"])));
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $b->get_Card2("edit", array(
    "header-title" => lang("Iris_Patients.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>