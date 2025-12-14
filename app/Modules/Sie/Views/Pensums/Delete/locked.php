<?php

$mpensums = model("App\Modules\Sie\Models\Sie_Pensums");
$pensum = $mpensums->get_Pensum($oid);

$bootstrap = service("bootstrap");
$continue = "/sie/versions/view/{$pensum["version"]}";

$card = $bootstrap->get_Card("access-denied", array(
    "class" => "card-danger",
    "title" => lang("Sie_Pensums.delete-locked-title"),
    "icon" => "fa-duotone fa-triangle-exclamation",
    "text-class" => "text-center",
    "text" => lang("Sie_Pensums.delete-locked-message"),
    "footer-class" => "text-center",
    "footer-continue" => $continue,
    "voice" => "sie/pensums-delete-locked-message.mp3"
));

echo($card);
?>