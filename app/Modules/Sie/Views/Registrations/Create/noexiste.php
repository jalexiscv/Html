<?php

//[model]---------------------------------------------------------------------------------------------------------------
$mproducts = model('App\Modules\Sie\Models\Sie_Products');
$morders = model('App\Modules\Sie\Models\Sie_Orders');
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
//[vars]----------------------------------------------------------------------------------------------------------------
$create = $mregistrations->insert($d);
// Se adiciona un estado al historial de estados
$status = array(
    "status" => pk(),
    "registration" => $d["registration"],
    "program" => $d["program"],
    "period" => $d["period"],
    "moment" => "1",
    "cycle" => "1",
    "reference" => "REGISTERED",
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => "SYSTEM",
    "locked_at" => safe_get_date(),
);
$create_status = $mstatuses->insert($status);

$order = $morders->getLastByUser($d["registration"]);

$print = "/sie/orders/print/" . @$order['order'] . "?origin=registrations-create";

$convenio = false;
//[buid]----------------------------------------------------------------------------------------------------------------
$product = $mproducts->get_Product("6657A680B1616");
$code = "";
$code .= "<img src=\"/themes/assets/images/start.png\" style=\"height: 100px;\" alt=\"\"/i>\n";
$code .= "\t\t\t\t\t\t\t\t<div class=\"pt-4 text-center\">\n";
if ($option=="agreements") {
    $code .= "\t\t\t\t\t\t\t\t\t\t<p class=\"m-0\">¡La preinscripción se ha realizado con éxito!\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t A continuación, debes cargar toda la documentación requerida en formato PDF, utilizando el siguiente botón para continuar con tu inscripción.</p>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t <br><p><a href=\"/sie/registrations/documents/{$d['registration']}\" class=\"btn btn-primary\">Cargar documentos requeridos</a></p>\n";
} else {
    $code .= "\t\t\t\t\t\t\t\t\t\t<p class=\"m-0\">¡La preinscripción se ha realizado con éxito! Puedes realizar el pago a través de <b>AvalPayGOU</b>, usando como\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\"número de desprendible\" el código de la orden de pago, que te damos a continuación.\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\trecordamos el valor de la inscripción.</p>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t<p class=\"m-0 fs-3 m-1\">\${$product['value']}</p>\n";
    //$code.="\t\t\t\t\t\t\t\t\t\t<p class=\"m-0\">Su numero de orden de pago:</p>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t<p class=\"m-0 fs-3 m-1\"><?php echo(@\$row_registration['ticket']); ?> </p>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t<p class=\"m-0\">También puedes descargar la orden, ver en ella otros métodos de pago para\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t inscribirte. Además, hemos enviado un correo electrónico con la misma orden a la dirección que\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t registraste. ¡Revisa tu bandeja de entrada y/o correo spam y prepárate para comenzar esta nueva etapa en Utedé!</p>\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t <br><p><a href=\"/sie/registrations/documents/{$d['registration']}\" class=\"btn btn-primary\">Cargar documentos requeridos</a></p>\n";
}
$code .= "\t\t\t\t\t\t\t\t</div>\n";


$c = $bootstrap->get_Card("success", array(
    "class" => "card",
    "title" => "Preinscripción exitosa!",
    "text-class" => "text-center",
    "text" => $code,
    "footer-continue" => array("text" => "Descargar recibo de pago", "href" => $print, "target" => "_blank"),
    "footer-class" => "text-center",
    "voice" => $asuccess,
));

?>