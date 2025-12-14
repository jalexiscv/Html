<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2024-10-28 01:11:42
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Application\Views\Clients\Editor\form.php]
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
$f = service("forms", array("lang" => "Settings_Clients."));
//[models]--------------------------------------------------------------------------------------------------------------
$mclients = model("App\Modules\Application\Models\Settings_Clients");
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
$row = $mclients->get_ClientByDomain($server::get_FullName());
$r["client"] = $f->get_Value("client", @$row["client"]);
$r["name"] = $f->get_Value("name", $row["name"]);
$r["smtp_host"] = $f->get_Value("smtp_host", $row["smtp_host"]);
$r["smtp_port"] = $f->get_Value("smtp_port", $row["smtp_port"]);
$r["smtp_smtpsecure"] = $f->get_Value("smtp_smtpsecure", $row["smtp_smtpsecure"]);
$r["smtp_smtpauth"] = $f->get_Value("smtp_smtpauth", $row["smtp_smtpauth"]);
$r["smtp_username"] = $f->get_Value("smtp_username", $row["smtp_username"]);
$r["smtp_password"] = $f->get_Value("smtp_password", $row["smtp_password"]);
$r["smtp_from_email"] = $f->get_Value("smtp_from_email", $row["smtp_from_email"]);
$r["smtp_from_name"] = $f->get_Value("smtp_from_name", $row["smtp_from_name"]);
$r["smtp_charset"] = $f->get_Value("smtp_charset", $row["smtp_charset"]);
$r["smtp_to"] = $f->get_Value("smtp_to", "jalexiscv@gmail.com");
$r["smtp_subjet"] = $f->get_Value("smtp_subjet", "Prueba de envio de correo");
$r["smtp_message"] = $f->get_Value("smtp_message", "Este es un mensaje de prueba de envio de correo desde la plataforma de Higgs.");
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = "/settings/emails/home/" . lpk();
$encryps = array(
    array("label" => "Seleccione una...", "value" => ""),
    array("label" => "SSL (ENCRYPTION_SMTPS)", "value" => "ssl"),
    array("label" => "TLS (ENCRYPTION_STARTTLS)", "value" => "tls"),
    array("label" => "NONE (ENCRYPTION_NONE)", "value" => "none")
);
$smtpsecures = array(
    array("label" => "Seleccione una...", "value" => ""),
    array("label" => "SI (SMTP_AUTH_YES)", "value" => "true"),
    array("label" => "NO (SMTP_AUTH_NO)", "value" => "false")
);

$charsets = array(
    array("label" => "Seleccione una...", "value" => ""),
    array("label" => "UTF-8", "value" => "UTF-8"),
    array("label" => "ISO-8859-1", "value" => "ISO-8859-1"),
);
//[fields]--------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("client", $r["client"]);
$f->add_HiddenField("author", $r["author"]);
$f->fields["smtp_host"] = $f->get_FieldText("smtp_host", array("value" => $r["smtp_host"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["smtp_port"] = $f->get_FieldText("smtp_port", array("value" => $r["smtp_port"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "true"));
$f->fields["smtp_smtpsecure"] = $f->get_FieldSelect("smtp_smtpsecure", array("selected" => $r["smtp_smtpsecure"], "data" => $encryps, "proportion" => "col-md-6 col-sm-12 col-12", "disabled" => true));
$f->fields["smtp_smtpauth"] = $f->get_FieldSelect("smtp_smtpauth", array("selected" => $r["smtp_smtpauth"], "data" => $smtpsecures, "proportion" => "col-md-6 col-sm-12 col-12", "disabled" => true));
$f->fields["smtp_username"] = $f->get_FieldText("smtp_username", array("value" => $r["smtp_username"], "proportion" => "col-md-6 col-sm-12 col-12", "readonly" => "true"));
$f->fields["smtp_password"] = $f->get_FieldText("smtp_password", array("value" => $r["smtp_password"], "proportion" => "col-md-6 col-sm-12 col-12", "readonly" => "true"));
$f->fields["smtp_from_email"] = $f->get_FieldText("smtp_from_email", array("value" => $r["smtp_from_email"], "proportion" => "col-md-6 col-sm-12 col-12", "readonly" => "true"));
$f->fields["smtp_from_name"] = $f->get_FieldText("smtp_from_name", array("value" => $r["smtp_from_name"], "proportion" => "col-md-6 col-sm-12 col-12", "readonly" => "true"));
$f->fields["smtp_charset"] = $f->get_FieldSelect("smtp_charset", array("selected" => $r["smtp_charset"], "data" => $charsets, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "disabled" => true));

$f->fields["smtp_to"] = $f->get_FieldText("smtp_to", array("value" => $r["smtp_to"], "proportion" => "col-12"));
$f->fields["smtp_subjet"] = $f->get_FieldText("smtp_subjet", array("value" => $r["smtp_subjet"], "proportion" => "col-12"));
$f->fields["smtp_message"] = $f->get_FieldTextArea("smtp_message", array("value" => $r["smtp_message"], "proportion" => "col-12"));

$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "true"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "true"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => "true"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Send"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["smtp_host"] . $f->fields["smtp_port"] . $f->fields["smtp_charset"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["smtp_username"] . $f->fields["smtp_password"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["smtp_smtpsecure"] . $f->fields["smtp_smtpauth"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["smtp_from_email"] . $f->fields["smtp_from_name"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["smtp_to"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["smtp_subjet"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["smtp_message"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => lang("Settings_Clients.smtp-test-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>