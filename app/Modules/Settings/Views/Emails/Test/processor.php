<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-28 01:11:42
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Application\Views\Clients\Editor\processor.php]
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
$mclients = model("App\Modules\Settings\Models\Settings_Clients");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Settings_Clients."));
$client = $mclients->get_Client($f->get_Value("client"));
$d = array(
    "client" => $f->get_Value("client"),
    "smtp_host" => $client["smtp_host"],
    "smtp_port" => $client["smtp_port"],
    "smtp_smtpsecure" => $client["smtp_smtpsecure"],
    "smtp_smtpauth" => $client["smtp_smtpauth"],
    "smtp_username" => $client["smtp_username"],
    "smtp_password" => $client["smtp_password"],
    "smtp_from_email" => $client["smtp_from_email"],
    "smtp_from_name" => $client["smtp_from_name"],
    "smtp_charset" => $client["smtp_charset"],
    "smtp_to" => $f->get_Value("smtp_to"),
    "smtp_subjet" => $f->get_Value("smtp_subjet"),
    "smtp_message" => $f->get_Value("smtp_message"),
);
//echo(safe_dump($d));
//[Elements]-----------------------------------------------------------------------------
$l["back"] = "/settings/emails/smtp/" . lpk();
$l["edit"] = "/application/clients/edit/{$d["client"]}";
$asuccess = "application/clients-edit-success-message.mp3";
$anoexist = "application/clients-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
$c = $bootstrap->get_Card("success", array(
    "class" => "card-success",
    "icon" => "fa-duotone fa-triangle-exclamation",
    "title" => lang("Settings_Clients.edit-success-title"),
    "text-class" => "text-center",
    "text" => lang("Settings_Clients.edit-success-message"),
    "footer-continue" => $l["back"],
    "footer-class" => "text-center",
    "voice" => $asuccess,
));
$send = view("App\Modules\Settings\Views\Emails\Test\send", $d);
echo($c);
echo($send);
?>