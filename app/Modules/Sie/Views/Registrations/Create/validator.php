<?php

$bootstrap = service('bootstrap');
//[models]--------------------------------------------------------------------------------------------------------------
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
//[vars]--------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Registrations."));
//[Request]-------------------------------------------------------------------------------------------------------------
$identification_number = $f->get_Value("identification_number");

$option = $f->get_Value("option");

$f->set_ValidationRule("registration", "trim|required");
$f->set_ValidationRule("journey", "trim|required");
$f->set_ValidationRule("program", "trim|required");
$f->set_ValidationRule("first_name", "trim|required");
$f->set_ValidationRule("first_surname", "trim|required");
$f->set_ValidationRule("identification_type", "trim|required");
$f->set_ValidationRule("identification_number", "trim|required|max_length[10]");
$f->set_ValidationRule("email_address", "trim|required");
$f->set_ValidationRule("phone", "trim|required");
$f->set_ValidationRule("gender", "trim|required");

if ($option == "agreements") {
    $f->set_ValidationRule("agreement", "trim|required");
    $f->set_ValidationRule("agreement_country", "trim|required");
    $f->set_ValidationRule("agreement_region", "trim|required");
    $f->set_ValidationRule("agreement_city", "trim|required");
    $f->set_ValidationRule("agreement_institution", "trim|required");
}

if (!empty($identification_number)) {
    $registration = $mregistrations->getRegistrationByIdentification($identification_number);
    if (!empty($registration['registration'])) {
        $f->validation->setError('identification_number', 'Ya existe alguien con este numero de identificación.');
    }
}

//[Validation]----------------------------------------------------------------------------------------------------------
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
//[Build]---------------------------------------------------------------------------------------------------------------
echo($c);
?>