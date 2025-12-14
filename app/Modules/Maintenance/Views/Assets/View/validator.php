<?php

$bootstrap = service('bootstrap');
$f = service("forms",array("lang" => "Maintenance_Assets."));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("asset","trim|required");
//$f->set_ValidationRule("name","trim|required");
//$f->set_ValidationRule("type","trim|required");
//$f->set_ValidationRule("status","trim|required");
//$f->set_ValidationRule("description","trim|required");

// Vehicle validation rules
$f->set_ValidationRule("license_plate","trim");
$f->set_ValidationRule("vehicle_brand","trim");
$f->set_ValidationRule("vehicle_line","trim");
$f->set_ValidationRule("engine_displacement","trim");
$f->set_ValidationRule("vehicle_model","trim");
$f->set_ValidationRule("vehicle_class","trim");
$f->set_ValidationRule("body_type","trim");
$f->set_ValidationRule("doors_number","trim|integer");
$f->set_ValidationRule("engine_number","trim");
$f->set_ValidationRule("serial_document","trim");
$f->set_ValidationRule("chassis_number","trim");
$f->set_ValidationRule("document_number","trim");
$f->set_ValidationRule("tonnage_capacity","trim");
$f->set_ValidationRule("city","trim");
$f->set_ValidationRule("passengers","trim|integer");
$f->set_ValidationRule("document_date","trim");
$f->set_ValidationRule("vehicle_function","trim");
$f->set_ValidationRule("authorized_drivers","trim");
$f->set_ValidationRule("maintenance_manager","trim");
$f->set_ValidationRule("photo_url","trim");
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