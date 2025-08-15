<?php
$msettings = model('App\Modules\Sie\Models\Sie_Settings');
$status = $msettings->getSetting("R-M-D");
$card = $bootstrap->get_Card("access-denied", array(
    "class" => "card-warning",
    "title" => "Formulario de inscripciones deshabilitado",
    "icon" => "fa-duotone fa-triangle-exclamation",
    "text-class" => "text-center",
    "text" => $status["value"],
    "footer-class" => "text-center",
    "footer-continue" => "/",
    "voice" => "app/permissions-denied-message.mp3"
));
echo($card);
?>