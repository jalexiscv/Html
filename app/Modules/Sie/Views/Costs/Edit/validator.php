<?php

$bootstrap = service('bootstrap');
$f = service("forms",array("lang" => "Sie_Costs."));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("cost","trim|required");
$f->set_ValidationRule("program","trim|required");
$f->set_ValidationRule("period","trim|required");
$f->set_ValidationRule("value","trim|required");
$f->set_ValidationRule("currency","trim|required");
$f->set_ValidationRule("valid_from","trim|required");
$f->set_ValidationRule("valid_until","trim|required");
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