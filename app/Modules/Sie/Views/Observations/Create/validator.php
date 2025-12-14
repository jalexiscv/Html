<?php

$bootstrap = service('bootstrap');
$request = service("request");
$f = service("forms", array("lang" => "Observations."));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("observation", "trim|required");
$f->set_ValidationRule("object", "trim|required");
$f->set_ValidationRule("type", "trim|required");
$f->set_ValidationRule("content", "trim|required");
//$f->set_ValidationRule("date","trim|required");
//$f->set_ValidationRule("time","trim|required");
//$f->set_ValidationRule("author","trim|required");
//$f->set_ValidationRule("created_at","trim|required");
//$f->set_ValidationRule("updated_at","trim|required");
//$f->set_ValidationRule("deleted_at","trim|required");
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
    $data = $parent->get_Array();
    $c .= view($component . '\form', $data);
}
//[Build]-----------------------------------------------------------------------------
echo($c);
?>