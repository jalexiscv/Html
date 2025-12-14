<?php

$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Notifications_Notifications."));
//[Request]-----------------------------------------------------------------------------
$f->set_ValidationRule("notification","trim|required");
$f->set_ValidationRule("user","trim|required");
//$f->set_ValidationRule("recipient_email","trim|required");
//$f->set_ValidationRule("recipient_phone","trim|required");
//$f->set_ValidationRule("type","trim|required");
//$f->set_ValidationRule("category","trim|required");
//$f->set_ValidationRule("priority","trim|required");
//$f->set_ValidationRule("subject","trim|required");
//$f->set_ValidationRule("message","trim|required");
//$f->set_ValidationRule("data","trim|required");
//$f->set_ValidationRule("is_read","trim|required");
//$f->set_ValidationRule("read_at","trim|required");
//$f->set_ValidationRule("email_sent","trim|required");
//$f->set_ValidationRule("email_sent_at","trim|required");
//$f->set_ValidationRule("email_error","trim|required");
//$f->set_ValidationRule("sms_sent","trim|required");
//$f->set_ValidationRule("sms_sent_at","trim|required");
//$f->set_ValidationRule("sms_error","trim|required");
//$f->set_ValidationRule("action_url","trim|required");
//$f->set_ValidationRule("action_text","trim|required");
//$f->set_ValidationRule("expires_at","trim|required");
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
    $c .= view($component . '\form', $parent->get_Array());
}
//[Build]-----------------------------------------------------------------------------
echo($c);
?>
