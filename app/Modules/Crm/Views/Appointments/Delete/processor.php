<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-01-18 22:03:19
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Crm\Views\Appointments\Editor\processor.php]
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
$bootstrap = service('Bootstrap');
$f = service("forms", array("lang" => "Appointments."));
//$model = model("App\Modules\Crm\Models\Crm_Appointments");
$pkey = $f->get_Value("pkey");
$row = $model->withDeleted()->find($pkey);
/* Vars */
$l["back"] = "/crm/appointments/list/" . lpk();
$l["edit"] = "/crm/appointments/edit/{$pkey}";
$vsuccess = "crm/appointments-delete-success-message.mp3";
$vnoexist = "crm/appointments-delete-noexist-message.mp3";
/* Build */
if (isset($row["appointment"])) {
    $delete = $model->delete($pkey);

    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Appointments.delete-success-title"),
        "text-class" => "text-center",
        "text" => lang("Appointments.delete-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vsuccess,
    ));
} else {
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Appointments.delete-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Appointments.delete-noexist-message"), $d['appointment']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vnoexist,
    ));
}
echo($c);
?>
