<?php


$request = service("request");
$bootstrap = service("bootstrap");
$back = $request->getVar("back");
$course = $request->getVar("course");
$continue = "{$back}?course={$course}";
if ($authentication->get_LoggedIn()) {
    $card = $bootstrap->get_Card("access-denied", array(
        "class" => "card-danger",
        "title" => lang("App.Access-denied-title"),
        "icon" => "fa-duotone fa-triangle-exclamation", "text-class" => "text-center", "text" => lang("App.Access-denied-message"),
        "permissions" => $permissions,
        "footer-class" => "text-center",
        "footer-login" => true,
        "footer-continue" => $continue,
        "voice" => "app/permissions-denied-message.mp3"
    ));
} else {
    $card = $bootstrap->get_Card("access-denied", array(
        "class" => "card-danger",
        "title" => lang("App.login-required-title"),
        "icon" => "fa-duotone fa-triangle-exclamation",
        "text-class" => "text-center",
        "text" => lang("App.login-required-message"),
        "permissions" => $permissions,
        "footer-class" => "text-center",
        "footer-login" => true,
        "footer-continue" => $continue,
        "voice" => "app/login-required-message.mp3"
    ));
}
echo($card);
?>