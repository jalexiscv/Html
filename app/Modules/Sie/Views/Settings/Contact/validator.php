<?php

$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Sie_Settings."));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("value-email-general", "trim|required");
$f->set_ValidationRule("value-email-treasury", "trim|required");
//$f->set_ValidationRule("date","trim|required");
//$f->set_ValidationRule("time","trim|required");
//$f->set_ValidationRule("author","trim|required");
//[build]---------------------------------------------------------------------------------------------------------------
if ($f->run_Validation()) {
    $c = view($component . '\processor', $parent->get_Array());
} else {
    $c = $bootstrap->get_Card('validator-error', array(
        'class' => 'card-danger',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'text' => lang("App.validator-errors-message"),
        'errors' => $f->validation->listErrors(),
        'footer-class' => 'text-center',
        'voice' => "app/validator-errors-message.mp3",
    ));
    $c .= view($component . '\form', $parent->get_Array());
}
echo($c);
?>
