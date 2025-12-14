<?php

//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
//[Variables]-----------------------------------------------------------------------------------------------------------
$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Sie_Registrations."));
$identification_number = $f->get_Value("identification_number");
$birth_date = $f->get_Value("birth_date");
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("registration", "trim|required");


//$f->set_ValidationRule("journey", "trim|required");
//$f->set_ValidationRule("program", "trim|required");
$f->set_ValidationRule("first_name", "trim|required");
$f->set_ValidationRule("first_surname", "trim|required");
$f->set_ValidationRule("identification_type", "trim|required");
$f->set_ValidationRule("identification_number", "trim|required");
//$f->set_ValidationRule("identification_date", "trim|required");
//$f->set_ValidationRule("identification_country", "trim|required");
//$f->set_ValidationRule("identification_region", "trim|required");
//$f->set_ValidationRule("identification_city", "trim|required");
$f->set_ValidationRule("gender", "trim|required");
$f->set_ValidationRule("email_address", "trim|required");
//$f->set_ValidationRule("phone", "trim|required|numeric|min_length[10]|max_length[15]");
//$f->set_ValidationRule("mobile", "trim|numeric|min_length[10]|max_length[15]");
//$f->set_ValidationRule("birth_date", "trim|required|valid_date[Y-m-d]");
//$f->set_ValidationRule("birth_country", "trim|required");
//$f->set_ValidationRule("birth_region", "trim|required");
//$f->set_ValidationRule("birth_city", "trim|required");
//$f->set_ValidationRule("address", "trim|required");
//$f->set_ValidationRule("residence_country", "trim|required");
//$f->set_ValidationRule("residence_region", "trim|required");
//$f->set_ValidationRule("residence_city", "trim|required");
//$f->set_ValidationRule("neighborhood", "trim|required");
//$f->set_ValidationRule("area", "trim|required");
//$f->set_ValidationRule("stratum", "trim|required");
//$f->set_ValidationRule("blood_type", "trim|required");
//$f->set_ValidationRule("marital_status", "trim|required");
//$f->set_ValidationRule("number_children", "trim|required");
//$f->set_ValidationRule("eps", "trim|required");
//$f->set_ValidationRule("education_level", "trim|required");
//$f->set_ValidationRule("linkage_type", "trim|required");


if (!empty($identification_number)) {
    $registration = $mregistrations->getRegistrationByIdentification($identification_number);
    if (!empty($registration['registration'])) {
        $f->validation->setError('identification_number', 'Ya existe alguien con este numero de identificación.');
    }
}


if (!empty($birth_date)) {
    $birthDate = new DateTime($birth_date);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;
    if ($age < 12 || $age > 75) {
        $f->validation->setError('birth_date', 'La edad debe estar entre 12 y 75 años.');
    }
}


//[Validation]-----------------------------------------------------------------------------
if ($f->run_Validation()) {
    $c = view($component . '\processor', $parent->get_Array());
} else {
    $c = $bootstrap->get_Card('access-denied', array(
        'class' => 'card-danger',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'text' => lang('App.validator-errors-message'),
        'errors' => $f->validation->listErrors(),
        'footer-class' => 'text-center',
        'voice' => "app/validator-errors-message.mp3",
    ));
    $c .= view($component . '\form', $parent->get_Array());
}
//[Build]-----------------------------------------------------------------------------
echo($c);
?>
