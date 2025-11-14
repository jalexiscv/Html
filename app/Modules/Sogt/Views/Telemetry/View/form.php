<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-08-26 00:44:29
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sogt\Views\Telemetry\Editor\form.php]
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
$f = service("forms", array("lang" => "Sogt_Telemetry."));
//[models]--------------------------------------------------------------------------------------------------------------
//[vars]----------------------------------------------------------------------------------------------------------------
$row = $model->getTelemetry($oid);
$r["telemetry"] = $row["telemetry"];
$r["device"] = $row["device"];
$r["user"] = $row["user"];
$r["latitude"] = $row["latitude"];
$r["longitude"] = $row["longitude"];
$r["altitude"] = $row["altitude"];
$r["speed"] = $row["speed"];
$r["heading"] = $row["heading"];
$r["gps_valid"] = $row["gps_valid"];
$r["satellites"] = $row["satellites"];
$r["network"] = $row["network"];
$r["battery"] = $row["battery"];
$r["ignition"] = $row["ignition"];
$r["event"] = $row["event"];
$r["motion"] = $row["motion"];
$r["timestamp"] = $row["timestamp"];
$r["author"] = $row["author"];
$r["created_at"] = $row["created_at"];
$r["updated_at"] = $row["updated_at"];
$r["deleted_at"] = $row["deleted_at"];
$back = $f->get_Value("back", $server->get_Referer());
//[Fields]-----------------------------------------------------------------------------
$f->fields["telemetry"] = $f->get_FieldView("telemetry", array("value" => $r["telemetry"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["device"] = $f->get_FieldView("device", array("value" => $r["device"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["user"] = $f->get_FieldView("user", array("value" => $r["user"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["latitude"] = $f->get_FieldView("latitude", array("value" => $r["latitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["longitude"] = $f->get_FieldView("longitude", array("value" => $r["longitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["altitude"] = $f->get_FieldView("altitude", array("value" => $r["altitude"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["speed"] = $f->get_FieldView("speed", array("value" => $r["speed"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["heading"] = $f->get_FieldView("heading", array("value" => $r["heading"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["gps_valid"] = $f->get_FieldView("gps_valid", array("value" => $r["gps_valid"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["satellites"] = $f->get_FieldView("satellites", array("value" => $r["satellites"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["network"] = $f->get_FieldView("network", array("value" => $r["network"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["battery"] = $f->get_FieldView("battery", array("value" => $r["battery"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["ignition"] = $f->get_FieldView("ignition", array("value" => $r["ignition"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["event"] = $f->get_FieldView("event", array("value" => $r["event"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["motion"] = $f->get_FieldView("motion", array("value" => $r["motion"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["timestamp"] = $f->get_FieldView("timestamp", array("value" => $r["timestamp"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->add_HiddenField("author", $r["author"]);
$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["edit"] = $f->get_Button("edit", array("href" => "/sogt/telemetry/edit/" . $oid, "text" => lang("App.Edit"), "class" => "btn btn-secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
//[Groups]-----------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["telemetry"] . $f->fields["device"] . $f->fields["user"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["latitude"] . $f->fields["longitude"] . $f->fields["altitude"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["speed"] . $f->fields["heading"] . $f->fields["gps_valid"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["satellites"] . $f->fields["network"] . $f->fields["battery"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["ignition"] . $f->fields["event"] . $f->fields["motion"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["timestamp"] . $f->fields["author"] . $f->fields["created_at"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["updated_at"] . $f->fields["deleted_at"])));
//[Buttons]-----------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["edit"] . $f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang("Sogt_Telemetry.view-title"),
    "header-back" => $back,
    "content" => $f,
));
echo($card);
?>
