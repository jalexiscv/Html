<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-05-12 05:21:17
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Settings\Editor\form.php]
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
$f = service("forms", array("lang" => "Sie_Settings."));
//[models]--------------------------------------------------------------------------------------------------------------
$msettings = model('App\Modules\Sie\Models\Sie_Settings');
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $msettings->getSetting($oid);
$r["setting"] = @$row["setting"];
$r["name"] = @$row["name"];
$r["value"] = @$row["value"];
$r["date"] = @$row["date"];
$r["time"] = @$row["time"];
$r["author"] = @$row["author"];
$back = $f->get_Value("back", $server->get_Referer());

$end_registrations_setting = "R-E-D";
$end_registrations_label = "Fecha de cierre de inscripciones y matrículas";
$end_registrations_value = sie_get_setting($end_registrations_setting);

$status_registrations_setting = "R-S";
$status_registrations = $msettings->getSetting($status_registrations_setting);
$status_registrations_label = "Estado del formulario de registro";
$status_registrations_value = @$status_registrations["value"];


if ($status_registrations_value == "ACTIVE") {
    $status_registrations_value = "Habilitado";
} else {
    $status_registrations_value = "Deshabilitado";
}

$status_registrations_agreements_setting = "R-S-A";
$status_registrations_agreements = $msettings->getSetting($status_registrations_agreements_setting);
$status_registrations_agreements_label = "Estado del formulario de registro por convenios";
$status_registrations_agreements_value = @$status_registrations_agreements["value"];


if ($status_registrations_agreements_value == "ACTIVE") {
    $status_registrations_agreements_value = "Habilitado";
} else {
    $status_registrations_agreements_value = "Deshabilitado";
}

$registrations_message_enabled_code = "R-M-E";
$registrations_message_enabled = $msettings->getSetting($registrations_message_enabled_code);
$registrations_message_enabled_label = "Mensaje de registro habilitado";
$registrations_message_enabled_value = @$registrations_message_enabled["value"];

$registrations_message_disabled_code = "R-M-D";
$registrations_message_disabled = $msettings->getSetting($registrations_message_disabled_code);
$registrations_message_disabled_label = "Mensaje de registro deshabilitado";
$registrations_message_disabled_value = @$registrations_message_disabled["value"];

//[Fields]-----------------------------------------------------------------------------
$f->fields["end_registrations_setting"] = $f->get_FieldView("setting", array("value" => $end_registrations_setting, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "disabled" => true));
$f->fields["end_registrations_name"] = $f->get_FieldView("name", array("value" => $end_registrations_label, "proportion" => "col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12"));
$f->fields["end_registrations_value"] = $f->get_FieldView("value", array("value" => $end_registrations_value, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["status_registrations_setting"] = $f->get_FieldView("setting", array("value" => $status_registrations_setting, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "disabled" => true));
$f->fields["status_registrations_name"] = $f->get_FieldView("name", array("value" => $status_registrations_label, "proportion" => "col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12"));
$f->fields["status_registrations_value"] = $f->get_FieldView("value", array("value" => $status_registrations_value, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["status_registrations_agreements_setting"] = $f->get_FieldView("setting", array("value" => $status_registrations_agreements_setting, "proportion" => "col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12", "disabled" => true));
$f->fields["status_registrations_agreements_name"] = $f->get_FieldView("name", array("value" => $status_registrations_agreements_label, "proportion" => "col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12"));
$f->fields["status_registrations_agreements_value"] = $f->get_FieldView("value", array("value" => $status_registrations_agreements_value, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));



$f->fields["registrations_message_enabled_code"] = $f->get_FieldView("setting", array("value" => $registrations_message_enabled_code, "proportion" => "col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["registrations_message_enabled_name"] = $f->get_FieldView("name", array("value" => $registrations_message_enabled_label, "proportion" => "col-md-9 col-sm-12 col-12"));
$f->fields["registrations_message_enabled_value"] = $f->get_FieldView("value", array("value" => $registrations_message_enabled_value, "proportion" => "col-12"));

$f->fields["registrations_message_disabled_code"] = $f->get_FieldView("setting", array("value" => $registrations_message_disabled_code, "proportion" => "col-xl-3 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["registrations_message_disabled_name"] = $f->get_FieldView("name", array("value" => $registrations_message_disabled_label, "proportion" => "col-md-8 col-sm-12 col-12"));
$f->fields["registrations_message_disabled_value"] = $f->get_FieldView("value", array("value" => $registrations_message_disabled_value, "proportion" => "col-12"));

$f->fields["date"] = $f->get_FieldView("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldView("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/sie/registrations/settings/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["end_registrations_setting"] . $f->fields["end_registrations_name"] . $f->fields["end_registrations_value"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status_registrations_setting"] . $f->fields["status_registrations_name"] . $f->fields["status_registrations_value"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status_registrations_agreements_setting"] . $f->fields["status_registrations_agreements_name"] . $f->fields["status_registrations_agreements_value"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["registrations_message_enabled_code"] . $f->fields["registrations_message_enabled_name"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["registrations_message_enabled_value"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["registrations_message_disabled_code"] . $f->fields["registrations_message_disabled_name"] . $f->fields["registrations_message_disabled_value"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card2("card-view-service", array(
    "header-title" => lang("Sie_Settings.registrations-view-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>