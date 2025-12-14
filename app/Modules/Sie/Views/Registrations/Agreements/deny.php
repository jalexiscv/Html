<?php
$bootstrap = service("bootstrap");
$continue = "/sie/registrations/list/" . lpk();

$msettings = model('App\Modules\Sie\Models\Sie_Settings');
$message = $msettings->getSetting("R-M-D ");


$card = $bootstrap->get_Card("access-denied", array(
    "class" => "card-danger",
    "title" => "Finalizado / Cerrado",
    "icon" => "fa-duotone fa-triangle-exclamation",
    "text-class" => "text-center",
    "text" => $message["value"],
    "footer-class" => "text-center",
    "footer-login" => true,
    "footer-continue" => $continue,
    "voice" => "app/login-required-message.mp3"
));

echo($card);
?>