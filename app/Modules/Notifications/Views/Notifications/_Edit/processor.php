<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-11-06 00:10:24
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Notifications\Views\Notifications\Editor\processor.php]
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
//$model = model("App\Modules\Notifications\Models\Notifications_Notifications");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Notifications_Notifications."));
$d = array(
    "notification" => $f->get_Value("notification"),
    "user" => $f->get_Value("user"),
    "recipient_email" => $f->get_Value("recipient_email"),
    "recipient_phone" => $f->get_Value("recipient_phone"),
    "type" => $f->get_Value("type"),
    "category" => $f->get_Value("category"),
    "priority" => $f->get_Value("priority"),
    "subject" => $f->get_Value("subject"),
    "message" => $f->get_Value("message"),
    "data" => $f->get_Value("data"),
    "is_read" => $f->get_Value("is_read"),
    "read_at" => $f->get_Value("read_at"),
    "email_sent" => $f->get_Value("email_sent"),
    "email_sent_at" => $f->get_Value("email_sent_at"),
    "email_error" => $f->get_Value("email_error"),
    "sms_sent" => $f->get_Value("sms_sent"),
    "sms_sent_at" => $f->get_Value("sms_sent_at"),
    "sms_error" => $f->get_Value("sms_error"),
    "action_url" => $f->get_Value("action_url"),
    "action_text" => $f->get_Value("action_text"),
    "expires_at" => $f->get_Value("expires_at"),
);
//[Elements]-----------------------------------------------------------------------------
$row = $model->find($d["notification"]);
$l["back"] = $f->get_Value("back");
$l["edit"] = "/notifications/notifications/edit/{$d["notification"]}";
$asuccess = "notifications/notifications-edit-success-message.mp3";
$anoexist = "notifications/notifications-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $model->update($d['notification'], $d);
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Notifications_Notifications.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Notifications_Notifications.edit-success-message"),
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
        "title" => lang("Notifications_Notifications.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Notifications_Notifications.edit-noexist-message"), $d['notification']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
cache()->clean();
?>
