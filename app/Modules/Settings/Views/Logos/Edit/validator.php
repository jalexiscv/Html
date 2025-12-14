<?php
/** @var $component */
/** @var $parent */
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Settings."));
//[vars]---------------------------------------------------------------------------------------------------------------
$f->set_ValidationRule("client", "trim|required");
//$f->set_ValidationRule("sigep","trim|required");
//$f->set_ValidationRule("name","trim|required");
//$f->set_ValidationRule("vision","trim|required");
//$f->set_ValidationRule("mision","trim|required");
//$f->set_ValidationRule("representative","trim|required");
//$f->set_ValidationRule("representative_position","trim|required");
//$f->set_ValidationRule("leader","trim|required");
//$f->set_ValidationRule("leader_position","trim|required");
//$f->set_ValidationRule("logo","trim|required");
//$f->set_ValidationRule("author","trim|required");
//$f->set_ValidationRule("created_at","trim|required");
//$f->set_ValidationRule("updated_at","trim|required");
//$f->set_ValidationRule("deleted_at","trim|required");

//[Validation]----------------------------------------------------------------------------------------------------------
if ($f->run_Validation()) {
    $c = view($component . '\processor', $parent->get_Array());
} else {
    $c = $bootstrap->get_Card('access-denied', array(
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
//[print]---------------------------------------------------------------------------------------------------------------
echo($c);
?>