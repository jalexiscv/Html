<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-04-08 11:49:14
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Maintenance\Views\Assets\Editor\form.php]
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
$f = service("forms", array("lang" => "Maintenance_Assets."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Maintenance\Models\Maintenance_Assets");
$msheets = model("App\Modules\Maintenance\Models\Maintenance_Sheets");
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
$row = $model->getAsset($oid);
$r["asset"] = $f->get_Value("asset", $row["asset"]);
$r["name"] = $f->get_Value("name", $row["name"]);
$r["type"] = $f->get_Value("type", $row["type"]);
$r["status"] = $f->get_Value("status", $row["status"]);
$r["description"] = $f->get_Value("description", $row["description"]);
$r["created_at"] = $f->get_Value("created_at", $row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at", $row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at", $row["deleted_at"]);
$r["author"] = $f->get_Value("author", safe_get_user());

$r["license_plate"] = $f->get_Value("license_plate", $msheets->getAsset($r["asset"], "license_plate"));
$r["vehicle_brand"] = $f->get_Value("vehicle_brand", $msheets->getAsset($r["asset"], "vehicle_brand"));
$r["vehicle_line"] = $f->get_Value("vehicle_line", $msheets->getAsset($r["asset"], "vehicle_line"));
$r["engine_displacement"] = $f->get_Value("engine_displacement", $msheets->getAsset($r["asset"], "engine_displacement"));
$r["vehicle_model"] = $f->get_Value("vehicle_model", $msheets->getAsset($r["asset"], "vehicle_model"));
$r["vehicle_class"] = $f->get_Value("vehicle_class", $msheets->getAsset($r["asset"], "vehicle_class"));
$r["body_type"] = $f->get_Value("body_type", $msheets->getAsset($r["asset"], "body_type"));
$r["doors_number"] = $f->get_Value("doors_number", $msheets->getAsset($r["asset"], "doors_number"));
$r["engine_number"] = $f->get_Value("engine_number", $msheets->getAsset($r["asset"], "engine_number"));
$r["chassis_number"] = $f->get_Value("chassis_number", $msheets->getAsset($r["asset"], "chassis_number"));
$r["serial_document"] = $f->get_Value("serial_document", $msheets->getAsset($r["asset"], "serial_document"));
$r["document_number"] = $f->get_Value("document_number", $msheets->getAsset($r["asset"], "document_number"));
$r["tonnage_capacity"] = $f->get_Value("tonnage_capacity", $msheets->getAsset($r["asset"], "tonnage_capacity"));
$r["city"] = $f->get_Value("city", $msheets->getAsset($r["asset"], "city"));
$r["passengers"] = $f->get_Value("passengers", $msheets->getAsset($r["asset"], "passengers"));
$r["document_date"] = $f->get_Value("document_date", $msheets->getAsset($r["asset"], "document_date"));
$r["vehicle_function"] = $f->get_Value("vehicle_function", $msheets->getAsset($r["asset"], "vehicle_function"));
$r["authorized_drivers"] = $f->get_Value("authorized_drivers", $msheets->getAsset($r["asset"], "authorized_drivers"));
$r["maintenance_manager"] = $f->get_Value("maintenance_manager", $msheets->getAsset($r["asset"], "maintenance_manager"));
$r["photo_url"] = $f->get_Value("photo_url", $msheets->getAsset($r["asset"], "photo_url"));

$back = $f->get_Value("back", $server->get_Referer());
$types = MAINTENANCE_TYPES;
$statuses = MAINTENANCE_STATUSES;
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back", $back);
$f->fields["asset"] = $f->get_FieldView("asset", array("value" => $r["asset"], "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12", "readonly" => true));
$f->fields["type"] = $f->get_FieldSelect("type", array("selected" => $r["type"], "data" => $types, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => $r["status"], "data" => $statuses, "proportion" => "col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldView("name", array("value" => $r["name"], "proportion" => "col-12"));
$f->fields["description"] = $f->get_FieldViewArea("description", array("value" => $r["description"], "proportion" => "col-12"));
//$f->fields["created_at"] = $f->get_FieldView("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
//$f->fields["updated_at"] = $f->get_FieldView("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
//$f->fields["deleted_at"] = $f->get_FieldView("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
//[custom]--------------------------------------------------------------------------------------------------------------
$f->fields["license_plate"] = $f->get_FieldView("license_plate", array("value" => @$r["license_plate"], "proportion" => "col-6"));
$f->fields["vehicle_brand"] = $f->get_FieldView("vehicle_brand", array("value" => @$r["vehicle_brand"], "proportion" => "col-6"));
$f->fields["vehicle_line"] = $f->get_FieldView("vehicle_line", array("value" => @$r["vehicle_line"], "proportion" => "col-6"));
$f->fields["engine_displacement"] = $f->get_FieldView("engine_displacement", array("value" => @$r["engine_displacement"], "proportion" => "col-6"));
$f->fields["vehicle_model"] = $f->get_FieldView("vehicle_model", array("value" => @$r["vehicle_model"], "proportion" => "col-6"));
$f->fields["vehicle_class"] = $f->get_FieldView("vehicle_class", array("value" => @$r["vehicle_class"], "proportion" => "col-6"));
$f->fields["body_type"] = $f->get_FieldView("body_type", array("value" => @$r["body_type"], "proportion" => "col-6"));
$f->fields["doors_number"] = $f->get_FieldView("doors_number", array("value" => @$r["doors_number"], "proportion" => "col-6"));
$f->fields["engine_number"] = $f->get_FieldView("engine_number", array("value" => @$r["engine_number"], "proportion" => "col-6"));
$f->fields["serial_document"] = $f->get_FieldView("serial_document", array("value" => @$r["serial_document"], "proportion" => "col-6"));
$f->fields["chassis_number"] = $f->get_FieldView("chassis_number", array("value" => @$r["chassis_number"], "proportion" => "col-6"));
$f->fields["document_number"] = $f->get_FieldView("document_number", array("value" => @$r["document_number"], "proportion" => "col-6"));
$f->fields["tonnage_capacity"] = $f->get_FieldView("tonnage_capacity", array("value" => @$r["tonnage_capacity"], "proportion" => "col-6"));
$f->fields["city"] = $f->get_FieldView("city", array("value" => @$r["city"], "proportion" => "col-6"));
$f->fields["passengers"] = $f->get_FieldView("passengers", array("value" => @$r["passengers"], "proportion" => "col-6"));
$f->fields["document_date"] = $f->get_FieldView("document_date", array("value" => @$r["document_date"], "proportion" => "col-6"));
$f->fields["vehicle_function"] = $f->get_FieldViewArea("vehicle_function", array("value" => @$r["vehicle_function"], "proportion" => "col-12"));
$f->fields["authorized_drivers"] = $f->get_FieldViewArea("authorized_drivers", array("value" => @$r["authorized_drivers"], "proportion" => "col-12"));
$f->fields["maintenance_manager"] = $f->get_FieldView("maintenance_manager", array("value" => @$r["maintenance_manager"], "proportion" => "col-6"));
$f->fields["photo_url"] = $f->get_FieldView("photo_url", array("value" => @$r["photo_url"], "proportion" => "col-6"));
//[/custom]--------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("author", $r["author"]);
$f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $back, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Edit"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["asset"] . $f->fields["type"] . $f->fields["status"])));
$f->groups["g2"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["name"])));
$f->groups["g3"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["description"])));
$f->groups["g4"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["license_plate"] . $f->fields["vehicle_brand"])));
$f->groups["g5"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["vehicle_line"] . $f->fields["engine_displacement"])));
$f->groups["g6"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["vehicle_model"] . $f->fields["vehicle_class"])));
$f->groups["g7"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["body_type"] . $f->fields["doors_number"])));
$f->groups["g8"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["engine_number"] . $f->fields["serial_document"])));
$f->groups["g9"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["chassis_number"] . $f->fields["document_number"])));
$f->groups["g10"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["tonnage_capacity"] . $f->fields["city"])));
$f->groups["g11"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["passengers"] . $f->fields["document_date"])));
$f->groups["g12"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["vehicle_function"])));
$f->groups["g13"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["authorized_drivers"])));
$f->groups["g14"] = $f->get_Group(array("legend" => "", "fields" => ($f->fields["maintenance_manager"] . $f->fields["photo_url"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] = $f->get_GroupSeparator();
//$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" => lang("Maintenance_Assets.edit-title"),
    "content" => $f,
    "header-add" => "/maintenance/maintenances/create/" . $oid,
    "header-back" => $back
));
echo($card);
?>