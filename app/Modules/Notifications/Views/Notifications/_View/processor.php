<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-11-06 00:10:22
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
//[services]------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
//[vars]----------------------------------------------------------------------------------------------------------------
/**
 * @var object $authentication Authentication service from the ModuleController.
 * @var object $bootstrap Instance of the Bootstrap class from the ModuleController.
 * @var string $component Complete URI to the requested component.
 * @var object $dates Date service from the ModuleController.
 * @var string $oid String representing the object received, usually an object/data to be viewed, transferred from the ModuleController.
 * @var object $parent Represents the ModuleController.
 * @var object $request Request service from the ModuleController.
 * @var object $strings String service from the ModuleController.
 * @var string $view String passed to the view defined in the viewer for evaluation.
 * @var string $viewer Complete URI to the view responsible for evaluating each requested view.
 * @var string $views Complete URI to the module views.
 **/
$f = service("forms", array("lang" => "Notifications_Notifications."));
$model = model("App\Modules\Notifications\Models\Notifications_Notifications");
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
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["notification"]);
if (isset($row["notification"])) {
//$edit = $model->update($d);
    $c = $bootstrap->get_Card('warning', array(
        'class' => 'card-warning',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Notifications_Notifications.view-success-title"),
        'text' => lang("Notifications_Notifications.view-success-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/notifications/notifications/view/{$d["notification"]}/" . lpk()),
        'voice' => "notifications/notifications-view-success-message.mp3",
    ));
} else {
    $c = $bootstrap->get_Card('success', array(
        'class' => 'card-success',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Notifications_Notifications.view-noexist-title"),
        'text' => lang("Notifications_Notifications.view-noexist-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/notifications/notifications"),
        'voice' => "notifications/notifications-view-noexist-message.mp3",
    ));
}
echo($c);
?>
