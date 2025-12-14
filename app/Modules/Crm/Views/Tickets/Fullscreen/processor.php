<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-01-20 20:43:28
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Crm\Views\Tickets\Creator\processor.php]
 * █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 * █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 * █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 * █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 * █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 * █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 * █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 * █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 * █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * █ @link https://www.codehiggs.com
 * █ @Version 1.5.0 @since PHP 7, PHP 8
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ Datos recibidos desde el controlador - @ModuleController
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Tickets."));
$mtickets = model("App\Modules\Crm\Models\Crm_Tickets");
$d = array(
    "ticket" => $f->get_Value("ticket"),
    "number" => $f->get_Value("number"),
    "agent" => $f->get_Value("agent"),
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "status" => $f->get_Value("status"),
    "author" => safe_get_user(),
);
$row = $mtickets->find($d["ticket"]);
$l["back"] = "/crm/tickets/fullscreen/65ad2b11649fa" . lpk();
$l["edit"] = "/crm/tickets/edit/{$d["ticket"]}";
$asuccess = "crm/tickets-create-success-message.mp3";
$aexist = "crm/tickets-create-exist-message.mp3";
if (is_array($row)) {
    $c = $card = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Tickets.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Tickets.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $mtickets->insert($d);
    //echo($mtickets->getLastQuery()->getQuery());
    $c = $card = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Tickets.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Tickets.create-success-message"), $d['ticket']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}


$direccion = 'Cra 14 6-32 L 102, Buga - Valle del Cauca';
$telefonos = '2395000';
$email = 'info@aguasdebuga.com.co';
$number = str_pad($d["number"], 3, "0", STR_PAD_LEFT);
$generator = new \App\Libraries\Barcode\BarcodeGeneratorHTML();
$codigo_barras = $generator->getBarcode($d["ticket"], $generator::TYPE_CODE_128);
$code = "<link rel=\"stylesheet\" href=\"/themes/assets/css/tickets.css?v=" . lpk() . "\" type=\"text/css\">\n";
$code .= "<div class=\"d-flex justify-content-center align-items-center\">\n";
$code .= "\t<widget id=\"printable\">\n";
$code .= "\t\t<div class=\"row\">\n";
$code .= "\t\t\t<div class=\"col text-center mt-4\">\n";
$code .= "\t\t\t\t<h2>AGUAS DE BUGA S.A. E.S.P.</h2>\n";
$code .= "\t\t\t\t<p><b>Código de registro</b>: {$d["ticket"]}</p>\n"; // Agrega código de registro
$code .= "\t\t\t\t<p><b>Fecha</b>: {$d["date"]} <b>Hora</b>: {$d["time"]} </p>\n"; // Agrega fecha
$code .= "\t\t\t\t<p></p>\n"; // Agrega hora
$code .= "\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "\t\t<div class=\"row mt-3\">\n"; // Agrega espacio en la parte superior para separar
$code .= "\t\t\t<div class=\"col text-center\">\n";
$code .= "\t\t\t\t<div class=\"number\">{$number}</div>\n"; // Número generado
$code .= "\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "\t\t<div class=\"row mt-3\">\n"; // Agrega espacio en la parte superior para separar
$code .= "\t\t\t<div class=\"col text-center\">\n";
$code .= "\t\t\t\t<p><b>Centro Experiencia al Usuario</b></p>\n"; // Agrega dirección
$code .= "\t\t\t\t<p><b>Dirección</b>: $direccion</p>\n"; // Agrega dirección
$code .= "\t\t\t\t<p><b>Números telefónicos</b>: $telefonos</p>\n"; // Agrega teléfonos
$code .= "\t\t\t\t<p><b>Correo electrónico</b>: $email</p>\n"; // Agrega email
$code .= "\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "\t\t<div class=\"row mt-3 mb-3\">\n"; // Agrega espacio en la parte superior para separar
$code .= "\t\t<div class=\"d-flex justify-content-center align-items-center\">\n";
$code .= "\t\t\t\t<div class=\"barcode\">$codigo_barras</div>\n"; // Nuevo - código de barras
$code .= "\t\t\t</div>\n";
$code .= "\t\t</div>\n";
$code .= "\t</widget>\n";
$code .= "<a id=\"continuar\" href=\"{$l["back"]}\">Imprimir</a>\n";
$code .= "</div>\n";

?>
<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mx-auto d-table h-100">
    <div class="d-table-cell align-middle">
        <?php echo($code); ?>
    </div>
</div>

<script>
    document.getElementById('continuar').onclick = function () {
        document.body.style.display = 'block';
        window.print();
    };
</script>