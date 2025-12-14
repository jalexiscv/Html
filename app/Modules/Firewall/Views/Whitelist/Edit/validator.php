<?php

$bootstrap = service('bootstrap');
$f = service("forms",array("lang" => "Firewall_Whitelist."));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("id","trim|required");
$f->set_ValidationRule("ip","trim|required");
//$f->set_ValidationRule("notes","trim|required");
//$f->set_ValidationRule("author","trim|required");
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