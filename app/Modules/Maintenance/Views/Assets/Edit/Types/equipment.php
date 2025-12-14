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
$authentication =service('authentication');
$server = service("server");
$f = service("forms",array("lang" => "Maintenance_Assets."));
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
$row= $model->getAsset($oid);
$r["asset"] = $f->get_Value("asset",$row["asset"]);
$r["reference"] = $f->get_Value("reference",$row["reference"]);
$r["fixedcode"] = $f->get_Value("fixedcode",$row["fixedcode"]);
$r["name"] = $f->get_Value("name",$row["name"]);
$r["type"] = $f->get_Value("type",$row["type"]);
$r["status"] = $f->get_Value("status",$row["status"]);
$r["description"] = $f->get_Value("description",$row["description"]);
$r["created_at"] = $f->get_Value("created_at",$row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at",$row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at",$row["deleted_at"]);
$r["author"] = $f->get_Value("author",safe_get_user());

$r["entry_date"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"entry_date"));
$r["location"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"location"));
$r["code"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"code"));
$r["brand"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"brand"));
$r["serial_number"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"serial_number"));
$r["voltage"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"voltage"));
$r["amperage"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"amperage"));
$r["frequency"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"frequency"));
$r["power"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"power"));
$r["model"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"model"));
$r["rpm"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"rpm"));
$r["operation_hours"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"operation_hours"));
$r["other_specifications"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"other_specifications"));
$r["document_type"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"document_type"));
$r["document_location"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"document_location"));
$r["equipment_function"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"equipment_function"));
$r["authorized_personnel"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"authorized_personnel"));
$r["maintenance_manager"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"maintenance_manager"));
$r["observations"] =$f->get_Value("license_plate",$msheets->getAsset($r["asset"],"observations"));

$back=$f->get_Value("back",$server->get_Referer());
$types = MAINTENANCE_TYPES;
$statuses = MAINTENANCE_STATUSES;
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back",$back);
$f->fields["asset"] = $f->get_FieldText("asset", array("value" => $r["asset"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12","readonly" => true));
$f->fields["reference"] = $f->get_FieldText("reference", array("value" => $r["reference"],"proportion"=>"col-6"));
$f->fields["fixedcode"] = $f->get_FieldText("fixedcode", array("value" => $r["fixedcode"],"proportion"=>"col-6"));
$f->fields["type"] = $f->get_FieldSelect("type", array("selected" => $r["type"],"data"=>$types,"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => $r["status"],"data"=>$statuses,"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["name"] = $f->get_FieldText("name", array("value" => $r["name"],"proportion"=>"col-12"));
$f->fields["description"] = $f->get_FieldTextArea("description", array("value" => $r["description"],"proportion"=>"col-12"));
//$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
//$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
//$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
//[custom]--------------------------------------------------------------------------------------------------------------
$f->fields["entry_date"] = $f->get_FieldDate("entry_date", array("value" => @$r["entry_date"],"proportion"=>"col-6"));
$f->fields["location"] = $f->get_FieldText("location", array("value" => @$r["location"],"proportion"=>"col-6"));
$f->fields["code"] = $f->get_FieldText("code", array("value" => @$r["code"],"proportion"=>"col-6"));
$f->fields["brand"] = $f->get_FieldText("brand", array("value" => @$r["brand"],"proportion"=>"col-6"));
$f->fields["serial_number"] = $f->get_FieldText("serial_number", array("value" => @$r["serial_number"],"proportion"=>"col-6"));
$f->fields["voltage"] = $f->get_FieldText("voltage", array("value" => @$r["voltage"],"proportion"=>"col-6"));
$f->fields["amperage"] = $f->get_FieldText("amperage", array("value" => @$r["amperage"],"proportion"=>"col-6"));
$f->fields["frequency"] = $f->get_FieldText("frequency", array("value" => @$r["frequency"],"proportion"=>"col-6"));
$f->fields["power"] = $f->get_FieldText("power", array("value" => @$r["power"],"proportion"=>"col-6"));
$f->fields["model"] = $f->get_FieldText("model", array("value" => @$r["model"],"proportion"=>"col-6"));
$f->fields["rpm"] = $f->get_FieldText("rpm", array("value" => @$r["rpm"],"proportion"=>"col-6"));
$f->fields["operation_hours"] = $f->get_FieldText("operation_hours", array("value" => @$r["operation_hours"],"proportion"=>"col-6"));
$f->fields["other_specifications"] = $f->get_FieldTextArea("other_specifications", array("value" => @$r["other_specifications"],"proportion"=>"col-12"));
$f->fields["document_type"] = $f->get_FieldText("document_type", array("value" => @$r["document_type"],"proportion"=>"col-6"));
$f->fields["document_location"] = $f->get_FieldText("document_location", array("value" => @$r["document_location"],"proportion"=>"col-6"));
$f->fields["equipment_function"] = $f->get_FieldTextArea("equipment_function", array("value" => @$r["equipment_function"],"proportion"=>"col-12"));
$f->fields["authorized_personnel"] = $f->get_FieldTextArea("authorized_personnel", array("value" => @$r["authorized_personnel"],"proportion"=>"col-12"));
$f->fields["maintenance_manager"] = $f->get_FieldText("maintenance_manager", array("value" => @$r["maintenance_manager"],"proportion"=>"col-12"));
$f->fields["observations"] = $f->get_FieldTextArea("observations", array("value" => @$r["observations"],"proportion"=>"col-12"));
//[/custom]--------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("author",$r["author"]);
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] =$f->get_Submit("submit", array("value" =>lang("App.Edit"),"proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["asset"].$f->fields["type"].$f->fields["status"])));
$f->groups["g1a"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["reference"].$f->fields["fixedcode"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["name"])));
$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["description"])));
$f->groups["g4"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["entry_date"].$f->fields["location"])));
$f->groups["g5"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["code"].$f->fields["brand"])));
$f->groups["g6"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["serial_number"].$f->fields["voltage"])));
$f->groups["g7"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["amperage"].$f->fields["frequency"])));
$f->groups["g8"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["power"].$f->fields["model"])));
$f->groups["g9"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["rpm"].$f->fields["operation_hours"])));
$f->groups["g10"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["other_specifications"])));
$f->groups["g11"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["document_type"].$f->fields["document_location"])));
$f->groups["g12"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["equipment_function"])));
$f->groups["g13"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["authorized_personnel"])));
$f->groups["g14"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["maintenance_manager"])));
$f->groups["g15"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["observations"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card2("create", array(
    "header-title" => lang("Maintenance_Assets.edit-title"),
    "content" =>$f,
    "header-back" =>$back
));
echo($card);
?>