<?php
$d['registration'] = $row['registration'];
$back = "https://www.utede.edu.co";
$edit = $mregistrations->update($d['registration'], $d);
$c = $bootstrap->get_Card("duplicate", array(
    "class" => "card-warning",
    "icon" => "fa-duotone fa-triangle-exclamation",
    "title" => lang("Sie_Registrations.create-duplicate-title"),
    "text-class" => "text-center",
    "text" => lang("Sie_Registrations.create-duplicate-message"),
    "footer-continue" => $l["back"],
    "footer-class" => "text-center",
    "voice" => $aexist,
));
?>