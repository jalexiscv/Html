<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-05-12 05:20:18
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Settings\Editor\processor.php]
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
$msettings = model('App\Modules\Sie\Models\Sie_Settings');
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Settings."));

$d = array(
    "setting" => "G-S",
);


//[Elements]-----------------------------------------------------------------------------
$l["back"] = $f->get_Value("back");
$l["edit"] = "/sie/settings/edit/{$d["setting"]}";
$asuccess = "sie/settings-edit-success-message.mp3";
$anoexist = "sie/settings-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------


$edit0 = $msettings->upsert(array(
    "setting" => "R-E-D",
    "name" => "R-E-D",
    "value" => $f->get_Value("end_registrations_value"),
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
));

$edit1 = $msettings->upsert(array(
    "setting" => "R-S",
    "name" => "R-S",
    "value" => $f->get_Value("status_registrations"),
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
));

$edit12 = $msettings->upsert(array(
    "setting" => "R-S-A",
    "name" => "R-S-A",
    "value" => $f->get_Value("status_registrations_agreements"),
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
));


$edit2 = $msettings->upsert(array(
    "setting" => "R-M-E",
    "name" => "R-M-E",
    "value" => $f->get_Value("registrations_message_enabled_value"),
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
));

$edit3 = $msettings->upsert(array(
    "setting" => "R-M-D",
    "name" => "R-M-D",
    "value" => $f->get_Value("registrations_message_disabled_value"),
    "date" => safe_get_date(),
    "time" => safe_get_time(),
    "author" => safe_get_user(),
));

$c = $bootstrap->get_Card("success", array(
    "class" => "card-success",
    "icon" => "fa-duotone fa-triangle-exclamation",
    "title" => lang("Sie_Settings.edit-success-title"),
    "text-class" => "text-center",
    "text" => lang("Sie_Settings.edit-success-message"),
    "footer-continue" => $l["back"],
    "footer-class" => "text-center",
    "voice" => $asuccess,
));

echo($c);
cache()->clean();
?>