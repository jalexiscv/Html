<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-05-12 05:20:18
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
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service("server");
$f = service("forms", array("lang" => "Sie_Settings."));
//[models]--------------------------------------------------------------------------------------------------------------
$msettings = model('App\Modules\Sie\Models\Sie_Settings');
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
$row = $msettings->getSetting($oid);
$r["setting"] = $f->get_Value("setting", @$row["setting"]);
$r["name"] = $f->get_Value("name", @$row["name"]);
$r["value"] = $f->get_Value("value", @$row["value"]);
$r["date"] = $f->get_Value("date", service("dates")::get_Date());
$r["time"] = $f->get_Value("time", service("dates")::get_Time());
$r["author"] = $f->get_Value("author", safe_get_user());
$back = $f->get_Value("back", $server->get_Referer());

$status_graduations_setting = "G-S";
$status_graduations = $msettings->getSetting($status_graduations_setting);
$status_graduations_label = "Estado del formulario de graduaciones";
$status_graduations_value = @$status_graduations["value"];

if ($status_graduations_value != "ACTIVE") {
    $status_graduations_value = "DISABLED";
}

$graduations_message_enabled_code = "G-M-E";
$graduations_message_enabled = $msettings->getSetting($graduations_message_enabled_code);
$graduations_message_enabled_label = "Mensaje de graduaciones habilitado";
$graduations_message_enabled_value = @$graduations_message_enabled["value"];

$graduations_message_disabled_code = "G-M-D";
$graduations_message_disabled = $msettings->getSetting($graduations_message_disabled_code);
$graduations_message_disabled_label = "Mensaje de graduaciones deshabilitado";
$graduations_message_disabled_value = @$graduations_message_disabled["value"];

$statuses = array(
    array("label" => "Habilitado", "value" => "ACTIVE"),
    array("label" => "Deshabilitado", "value" => "DISABLED")
);


//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->fields["status_graduations_setting"] = $f->get_FieldText("setting", array("value" => $status_graduations_setting, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["status_graduations_name"] = $f->get_FieldText("name", array("value" => $status_graduations_label, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["status_graduations_value"] = $f->get_FieldSelect("status_graduations", array("selected" => $status_graduations_value, "data" => $statuses, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));

$f->fields["graduations_message_enabled_code"] = $f->get_FieldText("setting", array("value" => $graduations_message_enabled_code, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["graduations_message_enabled_name"] = $f->get_FieldText("name", array("value" => $graduations_message_enabled_label, "proportion" => "col-md-8 col-sm-12 col-12", "readonly" => true));
$f->fields["graduations_message_enabled_value"] = $f->get_FieldCKEditor("graduations_message_enabled", array("value" => $graduations_message_enabled_value, "proportion" => "col-12"));

$f->fields["graduations_message_disabled_code"] = $f->get_FieldText("setting", array("value" => $graduations_message_disabled_code, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["graduations_message_disabled_name"] = $f->get_FieldText("name", array("value" => $graduations_message_disabled_label, "proportion" => "col-md-8 col-sm-12 col-12", "readonly" => true));
$f->fields["graduations_message_disabled_value"] = $f->get_FieldCKEditor("graduations_message_disabled", array("value" => $graduations_message_disabled_value, "proportion" => "col-12"));

$f->fields["date"] = $f->get_FieldText("date", array("value" => $r["date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["time"] = $f->get_FieldText("time", array("value" => $r["time"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["status_graduations_setting"] . $f->fields["status_graduations_name"] . $f->fields["status_graduations_value"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["graduations_message_enabled_code"] . $f->fields["graduations_message_enabled_name"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["graduations_message_enabled_value"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["graduations_message_disabled_code"] . $f->fields["graduations_message_disabled_name"] . $f->fields["graduations_message_disabled_value"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["graduations_message_disabled_value"])));

//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" => lang("Sie_Settings.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>