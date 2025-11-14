<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:20
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sogt\Views\Devices\Editor\form.php]
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
$f = service("forms", array("lang" => "Sogt_Devices."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Sogt\Models\Sogt_Devices");
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
$row = $model->getDevic($oid);
$r["device"] = $f->get_Value("device", $row["device"]);
$r["user"] = $f->get_Value("user", $row["user"]);
$r["tenant"] = $f->get_Value("tenant", $row["tenant"]);
$r["name"] = $f->get_Value("name", $row["name"]);
$r["alias"] = $f->get_Value("alias", $row["alias"]);
$r["device_type"] = $f->get_Value("device_type", $row["device_type"]);
$r["asset_type"] = $f->get_Value("asset_type", $row["asset_type"]);
$r["asset_ref"] = $f->get_Value("asset_ref", $row["asset_ref"]);
$r["imei"] = $f->get_Value("imei", $row["imei"]);
$r["serial"] = $f->get_Value("serial", $row["serial"]);
$r["iccid"] = $f->get_Value("iccid", $row["iccid"]);
$r["imsi"] = $f->get_Value("imsi", $row["imsi"]);
$r["mac_address"] = $f->get_Value("mac_address", $row["mac_address"]);
$r["vendor"] = $f->get_Value("vendor", $row["vendor"]);
$r["model"] = $f->get_Value("model", $row["model"]);
$r["firmware_version"] = $f->get_Value("firmware_version", $row["firmware_version"]);
$r["protocol"] = $f->get_Value("protocol", $row["protocol"]);
$r["transport"] = $f->get_Value("transport", $row["transport"]);
$r["server_host"] = $f->get_Value("server_host", $row["server_host"]);
$r["server_port"] = $f->get_Value("server_port", $row["server_port"]);
$r["apn"] = $f->get_Value("apn", $row["apn"]);
$r["carrier"] = $f->get_Value("carrier", $row["carrier"]);
$r["sim_phone"] = $f->get_Value("sim_phone", $row["sim_phone"]);
$r["auth_key"] = $f->get_Value("auth_key", $row["auth_key"]);
$r["ip_whitelist"] = $f->get_Value("ip_whitelist", $row["ip_whitelist"]);
$r["has_ignition"] = $f->get_Value("has_ignition", $row["has_ignition"]);
$r["has_sos"] = $f->get_Value("has_sos", $row["has_sos"]);
$r["has_temp"] = $f->get_Value("has_temp", $row["has_temp"]);
$r["has_fuel"] = $f->get_Value("has_fuel", $row["has_fuel"]);
$r["supports_ble"] = $f->get_Value("supports_ble", $row["supports_ble"]);
$r["report_interval_moving_s"] = $f->get_Value("report_interval_moving_s", $row["report_interval_moving_s"]);
$r["report_interval_idle_s"] = $f->get_Value("report_interval_idle_s", $row["report_interval_idle_s"]);
$r["overspeed_kmh"] = $f->get_Value("overspeed_kmh", $row["overspeed_kmh"]);
$r["timezone_offset_min"] = $f->get_Value("timezone_offset_min", $row["timezone_offset_min"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$r["activation_date"] = $f->get_Value("activation_date", $row["activation_date"]);
$r["installed_on"] = $f->get_Value("installed_on", $row["installed_on"]);
$r["installed_by"] = $f->get_Value("installed_by", $row["installed_by"]);
$r["warranty_until"] = $f->get_Value("warranty_until", $row["warranty_until"]);
$r["tags"] = $f->get_Value("tags", $row["tags"]);
$r["notes"] = $f->get_Value("notes", $row["notes"]);
$r["author"] = $f->get_Value("author", safe_get_user());
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$back = $f->get_Value("back", $server->get_Referer());
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->fields["device"] = $f->get_FieldText("device", array("value" => $r["device"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["user"] = $f->get_FieldText("user", array("value" => $r["user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["tenant"] = $f->get_FieldText("tenant", array("value" => $r["tenant"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["alias"] = $f->get_FieldText("alias", array("value" => $r["alias"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["device_type"] = $f->get_FieldText("device_type", array("value" => $r["device_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["asset_type"] = $f->get_FieldText("asset_type", array("value" => $r["asset_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["asset_ref"] = $f->get_FieldText("asset_ref", array("value" => $r["asset_ref"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["imei"] = $f->get_FieldText("imei", array("value" => $r["imei"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["serial"] = $f->get_FieldText("serial", array("value" => $r["serial"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["iccid"] = $f->get_FieldText("iccid", array("value" => $r["iccid"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["imsi"] = $f->get_FieldText("imsi", array("value" => $r["imsi"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["mac_address"] = $f->get_FieldText("mac_address", array("value" => $r["mac_address"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["vendor"] = $f->get_FieldText("vendor", array("value" => $r["vendor"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["model"] = $f->get_FieldText("model", array("value" => $r["model"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["firmware_version"] = $f->get_FieldText("firmware_version", array("value" => $r["firmware_version"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["protocol"] = $f->get_FieldText("protocol", array("value" => $r["protocol"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["transport"] = $f->get_FieldText("transport", array("value" => $r["transport"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["server_host"] = $f->get_FieldText("server_host", array("value" => $r["server_host"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["server_port"] = $f->get_FieldText("server_port", array("value" => $r["server_port"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["apn"] = $f->get_FieldText("apn", array("value" => $r["apn"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["carrier"] = $f->get_FieldText("carrier", array("value" => $r["carrier"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sim_phone"] = $f->get_FieldText("sim_phone", array("value" => $r["sim_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["auth_key"] = $f->get_FieldText("auth_key", array("value" => $r["auth_key"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ip_whitelist"] = $f->get_FieldText("ip_whitelist", array("value" => $r["ip_whitelist"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["has_ignition"] = $f->get_FieldText("has_ignition", array("value" => $r["has_ignition"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["has_sos"] = $f->get_FieldText("has_sos", array("value" => $r["has_sos"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["has_temp"] = $f->get_FieldText("has_temp", array("value" => $r["has_temp"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["has_fuel"] = $f->get_FieldText("has_fuel", array("value" => $r["has_fuel"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["supports_ble"] = $f->get_FieldText("supports_ble", array("value" => $r["supports_ble"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["report_interval_moving_s"] = $f->get_FieldText("report_interval_moving_s", array("value" => $r["report_interval_moving_s"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["report_interval_idle_s"] = $f->get_FieldText("report_interval_idle_s", array("value" => $r["report_interval_idle_s"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["overspeed_kmh"] = $f->get_FieldText("overspeed_kmh", array("value" => $r["overspeed_kmh"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["timezone_offset_min"] = $f->get_FieldText("timezone_offset_min", array("value" => $r["timezone_offset_min"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["activation_date"] = $f->get_FieldText("activation_date", array("value" => $r["activation_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["installed_on"] = $f->get_FieldText("installed_on", array("value" => $r["installed_on"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["installed_by"] = $f->get_FieldText("installed_by", array("value" => $r["installed_by"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["warranty_until"] = $f->get_FieldText("warranty_until", array("value" => $r["warranty_until"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["tags"] = $f->get_FieldText("tags", array("value" => $r["tags"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["notes"] = $f->get_FieldText("notes", array("value" => $r["notes"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["device"] . $f->fields["user"] . $f->fields["tenant"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["name"] . $f->fields["alias"] . $f->fields["device_type"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["asset_type"] . $f->fields["asset_ref"] . $f->fields["imei"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["serial"] . $f->fields["iccid"] . $f->fields["imsi"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["mac_address"] . $f->fields["vendor"] . $f->fields["model"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["firmware_version"] . $f->fields["protocol"] . $f->fields["transport"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["server_host"] . $f->fields["server_port"] . $f->fields["apn"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["carrier"] . $f->fields["sim_phone"] . $f->fields["auth_key"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ip_whitelist"] . $f->fields["has_ignition"] . $f->fields["has_sos"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["has_temp"] . $f->fields["has_fuel"] . $f->fields["supports_ble"])));
$f->groups["g11"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["report_interval_moving_s"] . $f->fields["report_interval_idle_s"] . $f->fields["overspeed_kmh"])));
$f->groups["g12"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["timezone_offset_min"] . $f->fields["status"] . $f->fields["activation_date"])));
$f->groups["g13"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["installed_on"] . $f->fields["installed_by"] . $f->fields["warranty_until"])));
$f->groups["g14"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["tags"] . $f->fields["notes"] . $f->fields["author"])));
$f->groups["g15"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["created_at"] . $f->fields["updated_at"] . $f->fields["deleted_at"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
    "title" => lang("Sogt_Devices.edit-title"),
    "content" => $f,
    "header-back" => $back
));
echo($card);
?>
