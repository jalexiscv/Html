<?php
/**
 * @var object $authentication Authentication service from the ModuleController.
 * @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
 * @var string $component Complete URI to the requested component.
 * @var object $dates Date service from the ModuleController.
 * @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
 * @var object $parent Represents the ModuleController.
 * @var object $request Request service from the ModuleController.
 * @var object $strings String service from the ModuleController.
 * @var string $view String passed to the view defined in the viewer for evaluation.
 * @var string $viewer Complete URI to the view responsible for evaluating each requested view.
 * @var string $views Complete URI to the module views.
 **/
$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Sie_Registrations."));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("registration", "trim|required");
$f->set_ValidationRule("course", "trim|required");
$f->set_ValidationRule("identification_type", "trim|required");
$f->set_ValidationRule("identification_number", "trim|required");
$f->set_ValidationRule("first_name", "trim|required");
$f->set_ValidationRule("first_surname", "trim|required");
$f->set_ValidationRule("email_address", "trim|required");
$f->set_ValidationRule("confirm_email_address", "trim|required");
$f->set_ValidationRule("gender", "trim|required");
$f->set_ValidationRule("phone", "trim|required");
$f->set_ValidationRule("residence_country", "trim|required");
$f->set_ValidationRule("residence_region", "trim|required");
$f->set_ValidationRule("residence_city", "trim|required");
//$f->set_ValidationRule("created_at","trim|required");
//$f->set_ValidationRule("updated_at","trim|required");
//$f->set_ValidationRule("deleted_at","trim|required");
//[Validation]-----------------------------------------------------------------------------
if ($f->run_Validation()) {
    $c = view($component . '\Courses\processor', $parent->get_Array());
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
    $c .= view($component . '\Courses\register', $parent->get_Array());
}
//[Build]-----------------------------------------------------------------------------
echo($c);
?>