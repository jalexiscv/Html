<?php


$code = "";
$card = $bootstrap->get_Card2("card-view-Firewall", array(
    "class" => "mb-3",
    "header-title" => "Estadisticas",
    "header-back" => "/",
    "image-class" => "img-fluid p-3",
    "content" => $code,
));
echo($card);
?>