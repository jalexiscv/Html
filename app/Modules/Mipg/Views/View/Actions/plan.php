<?php
/** @var  $bootstrap */
/** @var  $model */
/** @var  $oid */

$bootstrap = service("bootstrap");
$plan = $model->getPlan($oid);
$back = "/mipg/plans/view/{$oid}";

$code = "";

$card = $bootstrap->get_Card("card-view-service", array(
    "title" => sprintf("Acciones del plan de acción %s", $plan['order']),
    "header-back" => $back,
    "footer-continue" => $back,
    "content" => $code,
));
echo($card);
?>