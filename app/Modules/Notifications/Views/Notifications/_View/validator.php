<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-11-06 00:10:22
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Notifications\Views\Notifications\Creator\validator.php]
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
$bootstrap = service('bootstrap');
$f = service("forms", array("lang" => "Notifications_Notifications."));
//[Request]-----------------------------------------------------------------------------
//$f->set_ValidationRule("notification","trim|required");
//$f->set_ValidationRule("user","trim|required");
//$f->set_ValidationRule("recipient_email","trim|required");
//$f->set_ValidationRule("recipient_phone","trim|required");
//$f->set_ValidationRule("type","trim|required");
//$f->set_ValidationRule("category","trim|required");
//$f->set_ValidationRule("priority","trim|required");
//$f->set_ValidationRule("subject","trim|required");
//$f->set_ValidationRule("message","trim|required");
//$f->set_ValidationRule("data","trim|required");
//$f->set_ValidationRule("is_read","trim|required");
//$f->set_ValidationRule("read_at","trim|required");
//$f->set_ValidationRule("email_sent","trim|required");
//$f->set_ValidationRule("email_sent_at","trim|required");
//$f->set_ValidationRule("email_error","trim|required");
//$f->set_ValidationRule("sms_sent","trim|required");
//$f->set_ValidationRule("sms_sent_at","trim|required");
//$f->set_ValidationRule("sms_error","trim|required");
//$f->set_ValidationRule("action_url","trim|required");
//$f->set_ValidationRule("action_text","trim|required");
//$f->set_ValidationRule("expires_at","trim|required");
//$f->set_ValidationRule("created_at","trim|required");
//$f->set_ValidationRule("updated_at","trim|required");
//$f->set_ValidationRule("deleted_at","trim|required");
//[Validation]-----------------------------------------------------------------------------
if ($f->run_Validation()) {
    $c = view($component . '\processor', $parent->get_Array());
} else {
    $c = $bootstrap->get_Card('access-denied', array(
        'class' => 'card-danger',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'text' => lang('App.validator-errors-message'),
        'errors' => $f->validation->listErrors(),
        'footer-class' => 'text-center',
        'voice' => "app/validator-errors-message.mp3",
    ));
    $c .= view($component . '\form', $parent->get_Array());
}
//[Build]-----------------------------------------------------------------------------
echo($c);
?>
