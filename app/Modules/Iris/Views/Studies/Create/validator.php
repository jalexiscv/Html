<?php

$bootstrap = service('bootstrap');
$f = service("forms",array("lang" => "Iris_Studies."));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("study","trim|required");
$f->set_ValidationRule("episode","trim|required");
$f->set_ValidationRule("study_date","trim|required");
$f->set_ValidationRule("study_type","trim|required");
$f->set_ValidationRule("status","trim|required");
$f->set_ValidationRule("observations","trim|required");
//$f->set_ValidationRule("author","trim|required");
//$f->set_ValidationRule("created_at","trim|required");
//$f->set_ValidationRule("updated_at","trim|required");
//$f->set_ValidationRule("deleted_at","trim|required");
//[Validation]-----------------------------------------------------------------------------
if ($f->run_Validation()) {
   $c=view($component.'\processor',$parent->get_Array());
}else {
$c =$bootstrap->get_Card('access-denied', array(
    'class'=>'card-danger',
    'icon'=>'fa-duotone fa-triangle-exclamation',
    'text-class' => 'text-center',
    'text' => lang('App.validator-errors-message'),
    'errors' => $f->validation->listErrors(),
    'footer-class'=>'text-center',
    'voice'=>"app/validator-errors-message.mp3",
));
   $c.=view($component.'\form',$parent->get_Array());
}
//[Build]-----------------------------------------------------------------------------
echo($c);
?>