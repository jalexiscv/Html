<?php

$bootstrap = service("bootstrap");
$continue = "/sie/networks/list/" . lpk();

$card = $bootstrap->get_Card("access-denied", array(
    "class" => "card-danger",
    "title" => lang("Sie_Networks.delete-locked-title"),
    "icon" => "fa-duotone fa-triangle-exclamation",
    "text-class" => "text-center",
    "text" => lang("Sie_Networks.delete-locked-message"),
    "footer-class" => "text-center",
    "footer-continue" => $continue,
    "voice" => "sie/networks-delete-locked-message.mp3"
));

echo($card);
?>