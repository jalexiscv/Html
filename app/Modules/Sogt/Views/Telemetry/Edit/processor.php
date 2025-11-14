<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:30
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sogt\Views\Telemetry\Editor\processor.php]
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[services]------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sogt\Models\Sogt_Telemetry");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sogt_Telemetry."));
$d = array(
    "telemetry" => $f->get_Value("telemetry"),
    "device" => $f->get_Value("device"),
    "user" => $f->get_Value("user"),
    "latitude" => $f->get_Value("latitude"),
    "longitude" => $f->get_Value("longitude"),
    "altitude" => $f->get_Value("altitude"),
    "speed" => $f->get_Value("speed"),
    "heading" => $f->get_Value("heading"),
    "gps_valid" => $f->get_Value("gps_valid"),
    "satellites" => $f->get_Value("satellites"),
    "network" => $f->get_Value("network"),
    "battery" => $f->get_Value("battery"),
    "ignition" => $f->get_Value("ignition"),
    "event" => $f->get_Value("event"),
    "motion" => $f->get_Value("motion"),
    "timestamp" => $f->get_Value("timestamp"),
    "author" => safe_get_user(),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["telemetry"]);
$l["back"] = $f->get_Value("back");
$l["edit"] = "/sogt/telemetry/edit/{$d["telemetry"]}";
$asuccess = "sogt/telemetry-edit-success-message.mp3";
$anoexist = "sogt/telemetry-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $model->update($d['telemetry'], $d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sogt_Telemetry.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sogt_Telemetry.edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $model->insert($d);
    //echo($model->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sogt_Telemetry.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sogt_Telemetry.edit-noexist-message"), $d['telemetry']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
cache()->clean();
?>
