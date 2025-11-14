<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:19
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
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service("server");
$f = service("forms", array("lang" => "Sogt_Devices."));
//[models]--------------------------------------------------------------------------------------------------------------
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->getDevic($oid);
$r["device"] = $row["device"];
$r["user"] = $row["user"];
$r["tenant"] = $row["tenant"];
$r["name"] = $row["name"];
$r["alias"] = $row["alias"];
$r["device_type"] = $row["device_type"];
$r["asset_type"] = $row["asset_type"];
$r["asset_ref"] = $row["asset_ref"];
$r["imei"] = $row["imei"];
$r["serial"] = $row["serial"];
$r["iccid"] = $row["iccid"];
$r["imsi"] = $row["imsi"];
$r["mac_address"] = $row["mac_address"];
$r["vendor"] = $row["vendor"];
$r["model"] = $row["model"];
$r["firmware_version"] = $row["firmware_version"];
$r["protocol"] = $row["protocol"];
$r["transport"] = $row["transport"];
$r["server_host"] = $row["server_host"];
$r["server_port"] = $row["server_port"];
$r["apn"] = $row["apn"];
$r["carrier"] = $row["carrier"];
$r["sim_phone"] = $row["sim_phone"];
$r["auth_key"] = $row["auth_key"];
$r["ip_whitelist"] = $row["ip_whitelist"];
$r["has_ignition"] = $row["has_ignition"];
$r["has_sos"] = $row["has_sos"];
$r["has_temp"] = $row["has_temp"];
$r["has_fuel"] = $row["has_fuel"];
$r["supports_ble"] = $row["supports_ble"];
$r["report_interval_moving_s"] = $row["report_interval_moving_s"];
$r["report_interval_idle_s"] = $row["report_interval_idle_s"];
$r["overspeed_kmh"] = $row["overspeed_kmh"];
$r["timezone_offset_min"] = $row["timezone_offset_min"];
$r["status"] = $row["status"];
$r["activation_date"] = $row["activation_date"];
$r["installed_on"] = $row["installed_on"];
$r["installed_by"] = $row["installed_by"];
$r["warranty_until"] = $row["warranty_until"];
$r["tags"] = $row["tags"];
$r["notes"] = $row["notes"];
$r["author"] = $row["author"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];
$back = $f->get_Value("back", $server->get_Referer());
//[Fields]-----------------------------------------------------------------------------
$f->fields["device"] = $f->get_FieldView("device", array("value" => $r["device"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["user"] = $f->get_FieldView("user", array("value" => $r["user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["tenant"] = $f->get_FieldView("tenant", array("value" => $r["tenant"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldView("name", array("value" => $r["name"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["alias"] = $f->get_FieldView("alias", array("value" => $r["alias"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["device_type"] = $f->get_FieldView("device_type", array("value" => $r["device_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["asset_type"] = $f->get_FieldView("asset_type", array("value" => $r["asset_type"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["asset_ref"] = $f->get_FieldView("asset_ref", array("value" => $r["asset_ref"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["imei"] = $f->get_FieldView("imei", array("value" => $r["imei"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["serial"] = $f->get_FieldView("serial", array("value" => $r["serial"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["iccid"] = $f->get_FieldView("iccid", array("value" => $r["iccid"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["imsi"] = $f->get_FieldView("imsi", array("value" => $r["imsi"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["mac_address"] = $f->get_FieldView("mac_address", array("value" => $r["mac_address"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["vendor"] = $f->get_FieldView("vendor", array("value" => $r["vendor"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["model"] = $f->get_FieldView("model", array("value" => $r["model"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["firmware_version"] = $f->get_FieldView("firmware_version", array("value" => $r["firmware_version"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["protocol"] = $f->get_FieldView("protocol", array("value" => $r["protocol"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["transport"] = $f->get_FieldView("transport", array("value" => $r["transport"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["server_host"] = $f->get_FieldView("server_host", array("value" => $r["server_host"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["server_port"] = $f->get_FieldView("server_port", array("value" => $r["server_port"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["apn"] = $f->get_FieldView("apn", array("value" => $r["apn"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["carrier"] = $f->get_FieldView("carrier", array("value" => $r["carrier"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["sim_phone"] = $f->get_FieldView("sim_phone", array("value" => $r["sim_phone"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["auth_key"] = $f->get_FieldView("auth_key", array("value" => $r["auth_key"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ip_whitelist"] = $f->get_FieldView("ip_whitelist", array("value" => $r["ip_whitelist"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["has_ignition"] = $f->get_FieldView("has_ignition", array("value" => $r["has_ignition"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["has_sos"] = $f->get_FieldView("has_sos", array("value" => $r["has_sos"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["has_temp"] = $f->get_FieldView("has_temp", array("value" => $r["has_temp"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["has_fuel"] = $f->get_FieldView("has_fuel", array("value" => $r["has_fuel"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["supports_ble"] = $f->get_FieldView("supports_ble", array("value" => $r["supports_ble"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["report_interval_moving_s"] = $f->get_FieldView("report_interval_moving_s", array("value" => $r["report_interval_moving_s"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["report_interval_idle_s"] = $f->get_FieldView("report_interval_idle_s", array("value" => $r["report_interval_idle_s"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["overspeed_kmh"] = $f->get_FieldView("overspeed_kmh", array("value" => $r["overspeed_kmh"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["timezone_offset_min"] = $f->get_FieldView("timezone_offset_min", array("value" => $r["timezone_offset_min"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldView("status", array("value" => $r["status"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["activation_date"] = $f->get_FieldView("activation_date", array("value" => $r["activation_date"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["installed_on"] = $f->get_FieldView("installed_on", array("value" => $r["installed_on"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["installed_by"] = $f->get_FieldView("installed_by", array("value" => $r["installed_by"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["warranty_until"] = $f->get_FieldView("warranty_until", array("value" => $r["warranty_until"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["tags"] = $f->get_FieldView("tags", array("value" => $r["tags"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["notes"] = $f->get_FieldView("notes", array("value" => $r["notes"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/sogt/devices/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
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
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang("Sogt_Devices.view-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>
