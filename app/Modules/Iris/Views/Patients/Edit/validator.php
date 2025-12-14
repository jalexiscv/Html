<?php

$bootstrap = service('bootstrap');
$f = service("forms",array("lang" => "Iris_Patients."));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("patient", "trim|required");
//$f->set_ValidationRule("fhir_id","trim|required");
$f->set_ValidationRule("active", "trim|required");
$f->set_ValidationRule("document_type", "trim|required");
$f->set_ValidationRule("document_number", "trim|required");
$f->set_ValidationRule("document_issued_place", "trim|required");
$f->set_ValidationRule("first_name", "trim|required");
//$f->set_ValidationRule("middle_name","trim|required");
$f->set_ValidationRule("first_surname", "trim|required");
//$f->set_ValidationRule("second_surname","trim|required");
//$f->set_ValidationRule("full_name","trim|required");
$f->set_ValidationRule("gender", "trim|required");
//$f->set_ValidationRule("birth_date","trim|required");
//$f->set_ValidationRule("birth_place","trim|required");
//$f->set_ValidationRule("marital_status","trim|required");
//$f->set_ValidationRule("primary_phone","trim|required");
//$f->set_ValidationRule("secondary_phone","trim|required");
//$f->set_ValidationRule("email","trim|required");
//$f->set_ValidationRule("full_address","trim|required");
//$f->set_ValidationRule("neighborhood","trim|required");
//$f->set_ValidationRule("city","trim|required");
//$f->set_ValidationRule("state","trim|required");
//$f->set_ValidationRule("postal_code","trim|required");
//$f->set_ValidationRule("country","trim|required");
//$f->set_ValidationRule("residence_area","trim|required");
//$f->set_ValidationRule("socioeconomic_stratum","trim|required");
//$f->set_ValidationRule("emergency_contact_name","trim|required");
//$f->set_ValidationRule("emergency_contact_relationship","trim|required");
//$f->set_ValidationRule("emergency_contact_phone","trim|required");
//$f->set_ValidationRule("health_insurance","trim|required");
//$f->set_ValidationRule("health_regime","trim|required");
//$f->set_ValidationRule("affiliation_type","trim|required");
//$f->set_ValidationRule("ethnicity","trim|required");
//$f->set_ValidationRule("special_population","trim|required");
//$f->set_ValidationRule("has_diabetes","trim|required");
//$f->set_ValidationRule("has_hypertension","trim|required");
//$f->set_ValidationRule("family_history_glaucoma","trim|required");
//$f->set_ValidationRule("family_history_diabetes","trim|required");
//$f->set_ValidationRule("family_history_retinopathy","trim|required");
//$f->set_ValidationRule("previous_eye_surgeries","trim|required");
//$f->set_ValidationRule("blood_type","trim|required");
//$f->set_ValidationRule("allergies","trim|required");
//$f->set_ValidationRule("current_medications","trim|required");
//$f->set_ValidationRule("primary_language","trim|required");
//$f->set_ValidationRule("data_consent","trim|required");
//$f->set_ValidationRule("accepts_communications","trim|required");
//$f->set_ValidationRule("profile_photo","trim|required");
//$f->set_ValidationRule("observations","trim|required");
//$f->set_ValidationRule("created_by","trim|required");
//$f->set_ValidationRule("updated_by","trim|required");
//$f->set_ValidationRule("deleted_by","trim|required");
//$f->set_ValidationRule("created_at","trim|required");
//$f->set_ValidationRule("updated_at","trim|required");
//$f->set_ValidationRule("deleted_at","trim|required");
//[build]---------------------------------------------------------------------------------------------------------------
if ($f->run_Validation()) {
   $c=view($component.'\processor',$parent->get_Array());
}else {
$c =$bootstrap->get_Card('validator-error', array(
    'class'=>'card-danger',
    'icon'=>'fa-duotone fa-triangle-exclamation',
    'text-class' => 'text-center',
    'text' => lang("App.validator-errors-message"),
    'errors' => $f->validation->listErrors(),
    'footer-class'=>'text-center',
    'voice'=>"app/validator-errors-message.mp3",
));
   $c.=view($component.'\form',$parent->get_Array());
}
echo($c);
?>
