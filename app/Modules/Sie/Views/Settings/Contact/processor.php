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
$msettings = model("App\Modules\Sie\Models\Sie_Settings");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Settings."));


$emailGeneral = array(
    "setting" => "EMAIL-GENERAL",
    "name" => $f->get_Value("Email General"),
    "value" => $f->get_Value("value-email-general"),
    "date" => service("dates")::get_Date(),
    "time" => service("dates")::get_Time(),
    "author" => safe_get_user(),
);

$emailTreasury = array(
    "setting" => "EMAIL-TREASURY",
    "name" => $f->get_Value("Email de Tesoreria"),
    "value" => $f->get_Value("value-email-treasury"),
    "date" => service("dates")::get_Date(),
    "time" => service("dates")::get_Time(),
    "author" => safe_get_user(),
);

//[Elements]-----------------------------------------------------------------------------
$qgeneral = $msettings->find("EMAIL-GENERAL");
$qtreasury = $msettings->find("EMAIL-TREASURY");

$l["back"] = "/sie/settings/contact/" . lpk();
$l["edit"] = "/sie/settings/contact/" . lpk();
$asuccess = "sie/settings-edit-success-message.mp3";
$anoexist = "sie/settings-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($qgeneral)) {
    $edit = $msettings->update("EMAIL-GENERAL", $emailGeneral);
} else {
    $create = $msettings->insert($emailGeneral);
}

if (is_array($qtreasury)) {
    $edit = $msettings->update("EMAIL-TREASURY", $emailTreasury);
} else {
    $create = $msettings->insert($emailTreasury);
}

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