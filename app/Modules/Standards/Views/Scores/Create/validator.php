<?php

$bootstrap = service('bootstrap');
$f = service("forms",array("lang" => "Standards_Scores."));
//[Request]-----------------------------------------------------------------------------
$file_field_name = $f->get_FieldId("file");
$f->set_ValidationRule("score","trim|required");
$f->set_ValidationRule("object","trim|required");
$f->set_ValidationRule("value","trim|required");
$f->set_ValidationRule("description","trim|required");
$f->set_ValidationRule("file", "uploaded[$file_field_name]");
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