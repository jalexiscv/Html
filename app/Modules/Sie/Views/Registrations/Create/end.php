<?php

$bootstrap = service("bootstrap");
$continue = "/";

$card = $bootstrap->get_Card("access-denied", array(
    "class" => "card-danger",
    "title" => "Concluido",
    "icon" => "fa-duotone fa-triangle-exclamation",
    "text-class" => "text-center",
    "text" => "El periodo de registro ha finalizado. Por favor, contacte a nuestras oficinas para más información.",
    "footer-class" => "text-center",
    "footer-continue" => $continue,
    //"voice" => "app/permissions-denied-message.mp3"
));

echo($card);

?>