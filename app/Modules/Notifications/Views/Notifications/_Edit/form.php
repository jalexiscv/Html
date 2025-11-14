<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-11-06 00:10:24
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Notifications\Views\Notifications\Editor\form.php]
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service("server");
$f = service("forms", array("lang" => "Notifications_Notifications."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Notifications\Models\Notifications_Notifications");
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
$row = $model->getNotification($oid);
$r["notification"] = $f->get_Value("notification", $row["notification"]);
$r["user"] = $f->get_Value("user", $row["user"]);
$r["recipient_email"] = $f->get_Value("recipient_email", $row["recipient_email"]);
$r["recipient_phone"] = $f->get_Value("recipient_phone", $row["recipient_phone"]);
$r["type"] = $f->get_Value("type", $row["type"]);
$r["category"] = $f->get_Value("category", $row["category"]);
$r["priority"] = $f->get_Value("priority", $row["priority"]);
$r["subject"] = $f->get_Value("subject", $row["subject"]);
$r["message"] = $f->get_Value("message", $row["message"]);
$r["data"] = $f->get_Value("data", $row["data"]);
$r["is_read"] = $f->get_Value("is_read", $row["is_read"]);
$r["read_at"] = $f->get_Value("read_at", $row["read_at"]);
$r["email_sent"] = $f->get_Value("email_sent", $row["email_sent"]);
$r["email_sent_at"] = $f->get_Value("email_sent_at", $row["email_sent_at"]);
$r["email_error"] = $f->get_Value("email_error", $row["email_error"]);
$r["sms_sent"] = $f->get_Value("sms_sent", $row["sms_sent"]);
$r["sms_sent_at"] = $f->get_Value("sms_sent_at", $row["sms_sent_at"]);
$r["sms_error"] = $f->get_Value("sms_error", $row["sms_error"]);
$r["action_url"] = $f->get_Value("action_url", $row["action_url"]);
$r["action_text"] = $f->get_Value("action_text", $row["action_text"]);
$r["expires_at"] = $f->get_Value("expires_at", $row["expires_at"]);
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = $f->get_Value("back", $server->get_Referer());
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->fields["notification"] = $f->get_FieldText("notification", array("value" => $r["notification"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["user"] = $f->get_FieldText("user", array("value" => $r["user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["recipient_email"] = $f->get_FieldText("recipient_email", array("value" => $r["recipient_email"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["recipient_phone"] = $f->get_FieldText("recipient_phone", array("value" => $r["recipient_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldText("type", array("value" => $r["type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["category"] = $f->get_FieldText("category", array("value" => $r["category"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["priority"] = $f->get_FieldText("priority", array("value" => $r["priority"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["subject"] = $f->get_FieldText("subject", array("value" => $r["subject"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["message"] = $f->get_FieldText("message", array("value" => $r["message"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["data"] = $f->get_FieldText("data", array("value" => $r["data"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["is_read"] = $f->get_FieldText("is_read", array("value" => $r["is_read"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["read_at"] = $f->get_FieldText("read_at", array("value" => $r["read_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email_sent"] = $f->get_FieldText("email_sent", array("value" => $r["email_sent"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email_sent_at"] = $f->get_FieldText("email_sent_at", array("value" => $r["email_sent_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email_error"] = $f->get_FieldText("email_error", array("value" => $r["email_error"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sms_sent"] = $f->get_FieldText("sms_sent", array("value" => $r["sms_sent"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sms_sent_at"] = $f->get_FieldText("sms_sent_at", array("value" => $r["sms_sent_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sms_error"] = $f->get_FieldText("sms_error", array("value" => $r["sms_error"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["action_url"] = $f->get_FieldText("action_url", array("value" => $r["action_url"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["action_text"] = $f->get_FieldText("action_text", array("value" => $r["action_text"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["expires_at"] = $f->get_FieldText("expires_at", array("value" => $r["expires_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["notification"] . $f->fields["user"] . $f->fields["recipient_email"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["recipient_phone"] . $f->fields["type"] . $f->fields["category"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["priority"] . $f->fields["subject"] . $f->fields["message"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["data"] . $f->fields["is_read"] . $f->fields["read_at"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["email_sent"] . $f->fields["email_sent_at"] . $f->fields["email_error"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["sms_sent"] . $f->fields["sms_sent_at"] . $f->fields["sms_error"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["action_url"] . $f->fields["action_text"] . $f->fields["expires_at"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["created_at"] . $f->fields["updated_at"] . $f->fields["deleted_at"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => lang("Notifications_Notifications.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
