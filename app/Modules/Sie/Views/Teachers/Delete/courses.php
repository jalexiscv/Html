<?php
$bootstrap = service("bootstrap");
$continue = "/sie/teachers/list/" . lpk();
$card = $bootstrap->get_Card("access-denied", array(
    "class" => "card-danger",
    "title" => lang("Sie_Teachers.delete-deny-courses-title"),
    "icon" => "fa-duotone fa-triangle-exclamation",
    "text-class" => "text-center",
    "text" => lang("Sie_Teachers.delete-deny-courses-text"),
    "footer-class" => "text-center",
    "footer-login" => true,
    "footer-continue" => $continue,
    "voice" => "sie/teachers-delete-deny-courses-message.mp3"
));
echo($card);
?>