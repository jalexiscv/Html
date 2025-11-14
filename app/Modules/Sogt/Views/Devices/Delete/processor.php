<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:21
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sogt\Views\Devices\Editor\processor.php]
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
$bootstrap = service('Bootstrap');
$f = service("forms", array("lang" => "Sogt_Devices."));
//$model = model("App\Modules\Sogt\Models\Sogt_Devices");
$pkey = $f->get_Value("pkey");
$row = $model->withDeleted()->find($pkey);
/* Vars */
$l["back"] = $f->get_Value("back");
$l["edit"] = "/sogt/devices/edit/{$pkey}";
$vsuccess = "sogt/devices-delete-success-message.mp3";
$vnoexist = "sogt/devices-delete-noexist-message.mp3";
/* Build */
if (isset($row["device"])) {
    $delete = $model->delete($pkey);

    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sogt_Devices.delete-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sogt_Devices.delete-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vsuccess,
    ));
} else {
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sogt_Devices.delete-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sogt_Devices.delete-noexist-message"), $d['device']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vnoexist,
    ));
}
echo($c);
cache()->clean();
?>
