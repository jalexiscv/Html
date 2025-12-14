<?php

$msubsectors = model("App\Modules\Sie\Models\Sie_Subsectors");
$subsector = $msubsectors->getSubsector($oid);

$bootstrap = service("bootstrap");
$continue = "/sie/networks/view/{$subsector["network"]}";

$card = $bootstrap->get_Card("access-denied", array(
    "class" => "card-danger",
    "title" => lang("Sie_Subsectors.delete-locked-title"),
    "icon" => "fa-duotone fa-triangle-exclamation",
    "text-class" => "text-center",
    "text" => lang("Sie_Subsectors.delete-locked-message"),
    "footer-class" => "text-center",
    "footer-continue" => $continue,
    "voice" => "sie/subsectors-delete-locked-message.mp3"
));

echo($card);
?>