<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-21 21:56:09
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Registrations\Creator\processor.php]
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
 * █ @link https://www.higgs.com.co
 * █ @Version 1.5.1 @since PHP 8,PHP 9
 * █ ---------------------------------------------------------------------------------------------------------------------
 **/
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Registrations."));
$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$morders = model('App\Modules\Sie\Models\Sie_Orders');
$mitems = model('App\Modules\Sie\Models\Sie_Orders_Items');
//[Vars]-----------------------------------------------------------------------------
$newTicket = $morders->getNextTicketNumber();

$back = "https://www.utede.edu.co";

$d = array(
    "registration" => $f->get_Value("registration"),
    "identification_number" => $f->get_Value("identification_number"),
);

$registration = $mregistrations->getRegistrationByIdentification($d['identification_number']);


if (is_array($registration) && isset($registration['registration'])) {
    $order = $morders->getLastByUser($registration["registration"]);

    $href = "/sie/orders/print/" . @$order['order'] . "?origin=registrations";
    $print = "<a id=\"btn-print\" class=\"btn btn btn-danger mx-1\" href=\"{$href}\" target=\"_blank\"><i class=\"fa-regular fa-print\"></i> Imprimir recibo</a>";

    $card = $bootstrap->get_Card("delete-{$oid}", array(
        "class" => "card-info",
        "icon" => ICON_WARNING,
        "title" => lang("Sie_Registrations.registration_exist_title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Registrations.registration_exist_message"),
        "content" => "",
        "footer" => $print,
        "footer-class" => "text-center",
        "footer-cancel" => "/sie/registrations/updates/" . lpk(),
        "footer-attachment" => array(
            "text" => "Cargar documentos",
            "href" => "/sie/registrations/documents/" . $registration['registration']
        ),
        "header-back" => $back
    ));
} else {
    $card = $bootstrap->get_Card("delete-{$oid}", array(
        "class" => "card-info",
        "icon" => ICON_INFO,
        "title" => lang("Sie_Registrations.registration_notexist_title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Registrations.registration_notexist_message"),
        "content" => "",
        "header-back" => $back,
        "footer-class" => "text-center",
        "footer-cancel" => "/sie/registrations/updates/" . lpk(),
        "footer-continue" => array(
            "text" => "Acepto",
            "href" => "/sie/registrations/create/" . $newTicket . "?option=agreements"
        ),
    ));
}
echo($card);
?>