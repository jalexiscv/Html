<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-11-06 00:10:22
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
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service("server");
$f = service("forms", array("lang" => "Notifications_Notifications."));
//[models]--------------------------------------------------------------------------------------------------------------
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->getNotification($oid);
$r["notification"] = $row["notification"];
$r["user"] = $row["user"];
$r["recipient_email"] = $row["recipient_email"];
$r["recipient_phone"] = $row["recipient_phone"];
$r["type"] = $row["type"];
$r["category"] = $row["category"];
$r["priority"] = $row["priority"];
$r["subject"] = $row["subject"];
$r["message"] = $row["message"];
$r["data"] = $row["data"];
$r["is_read"] = $row["is_read"];
$r["read_at"] = $row["read_at"];
$r["email_sent"] = $row["email_sent"];
$r["email_sent_at"] = $row["email_sent_at"];
$r["email_error"] = $row["email_error"];
$r["sms_sent"] = $row["sms_sent"];
$r["sms_sent_at"] = $row["sms_sent_at"];
$r["sms_error"] = $row["sms_error"];
$r["action_url"] = $row["action_url"];
$r["action_text"] = $row["action_text"];
$r["expires_at"] = $row["expires_at"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];
$back = $f->get_Value("back", $server->get_Referer());
//[Fields]-----------------------------------------------------------------------------
$f->fields["notification"] = $f->get_FieldView("notification", array("value" => $r["notification"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["user"] = $f->get_FieldView("user", array("value" => $r["user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["recipient_email"] = $f->get_FieldView("recipient_email", array("value" => $r["recipient_email"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["recipient_phone"] = $f->get_FieldView("recipient_phone", array("value" => $r["recipient_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["type"] = $f->get_FieldView("type", array("value" => $r["type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["category"] = $f->get_FieldView("category", array("value" => $r["category"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["priority"] = $f->get_FieldView("priority", array("value" => $r["priority"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["subject"] = $f->get_FieldView("subject", array("value" => $r["subject"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["message"] = $f->get_FieldView("message", array("value" => $r["message"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["data"] = $f->get_FieldView("data", array("value" => $r["data"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["is_read"] = $f->get_FieldView("is_read", array("value" => $r["is_read"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["read_at"] = $f->get_FieldView("read_at", array("value" => $r["read_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email_sent"] = $f->get_FieldView("email_sent", array("value" => $r["email_sent"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email_sent_at"] = $f->get_FieldView("email_sent_at", array("value" => $r["email_sent_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["email_error"] = $f->get_FieldView("email_error", array("value" => $r["email_error"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sms_sent"] = $f->get_FieldView("sms_sent", array("value" => $r["sms_sent"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sms_sent_at"] = $f->get_FieldView("sms_sent_at", array("value" => $r["sms_sent_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sms_error"] = $f->get_FieldView("sms_error", array("value" => $r["sms_error"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["action_url"] = $f->get_FieldView("action_url", array("value" => $r["action_url"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["action_text"] = $f->get_FieldView("action_text", array("value" => $r["action_text"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["expires_at"] = $f->get_FieldView("expires_at", array("value" => $r["expires_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/notifications/notifications/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["notification"] . $f->fields["user"] . $f->fields["recipient_email"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["recipient_phone"] . $f->fields["type"] . $f->fields["category"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["priority"] . $f->fields["subject"] . $f->fields["message"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["data"] . $f->fields["is_read"] . $f->fields["read_at"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["email_sent"] . $f->fields["email_sent_at"] . $f->fields["email_error"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["sms_sent"] . $f->fields["sms_sent_at"] . $f->fields["sms_error"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["action_url"] . $f->fields["action_text"] . $f->fields["expires_at"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["created_at"] . $f->fields["updated_at"] . $f->fields["deleted_at"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang("Notifications_Notifications.view-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>
