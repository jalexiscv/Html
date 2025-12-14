<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-10-03 07:00:00
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Mstudies\Editor\form.php]
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
$f = service("forms",array("lang" => "Iris_Mstudies."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Iris\Models\Iris_Mstudies");
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
$row= $model->getMstudy($oid);
$r["mstudy"] = $f->get_Value("mstudy",$row["mstudy"]);
$r["loinc_code"] = $f->get_Value("loinc_code",$row["loinc_code"]);
$r["short_name"] = $f->get_Value("short_name",$row["short_name"]);
$r["long_name"] = $f->get_Value("long_name",$row["long_name"]);
$r["common_name"] = $f->get_Value("common_name",$row["common_name"]);
$r["coding_system"] = $f->get_Value("coding_system",$row["coding_system"]);
$r["code_version"] = $f->get_Value("code_version",$row["code_version"]);
$r["category"] = $f->get_Value("category",$row["category"]);
$r["subcategory"] = $f->get_Value("subcategory",$row["subcategory"]);
$r["procedure_type"] = $f->get_Value("procedure_type",$row["procedure_type"]);
$r["modality"] = $f->get_Value("modality",$row["modality"]);
$r["cpt_code"] = $f->get_Value("cpt_code",$row["cpt_code"]);
$r["snomed_code"] = $f->get_Value("snomed_code",$row["snomed_code"]);
$r["status"] = $f->get_Value("status",$row["status"]);
$r["replaced_by"] = $f->get_Value("replaced_by",$row["replaced_by"]);
$r["patient_instructions"] = $f->get_Value("patient_instructions",$row["patient_instructions"]);
$r["duration_minutes"] = $f->get_Value("duration_minutes",$row["duration_minutes"]);
$r["requires_consent"] = $f->get_Value("requires_consent",$row["requires_consent"]);
$r["notes"] = $f->get_Value("notes",$row["notes"]);
$r["created_by"] = $f->get_Value("created_by",$row["created_by"]);
$r["updated_by"] = $f->get_Value("updated_by",$row["updated_by"]);
$r["deleted_by"] = $f->get_Value("deleted_by",$row["deleted_by"]);
$r["created_at"] = $f->get_Value("created_at",$row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at",$row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at",$row["deleted_at"]);
$back=$f->get_Value("back",$server->get_Referer());
//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back",$back);
$f->fields["mstudy"] = $f->get_FieldText("mstudy", array("value" => $r["mstudy"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["loinc_code"] = $f->get_FieldText("loinc_code", array("value" => $r["loinc_code"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["short_name"] = $f->get_FieldText("short_name", array("value" => $r["short_name"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["long_name"] = $f->get_FieldText("long_name", array("value" => $r["long_name"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["common_name"] = $f->get_FieldText("common_name", array("value" => $r["common_name"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["coding_system"] = $f->get_FieldText("coding_system", array("value" => $r["coding_system"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["code_version"] = $f->get_FieldText("code_version", array("value" => $r["code_version"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["category"] = $f->get_FieldText("category", array("value" => $r["category"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["subcategory"] = $f->get_FieldText("subcategory", array("value" => $r["subcategory"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["procedure_type"] = $f->get_FieldText("procedure_type", array("value" => $r["procedure_type"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["modality"] = $f->get_FieldText("modality", array("value" => $r["modality"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cpt_code"] = $f->get_FieldText("cpt_code", array("value" => $r["cpt_code"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["snomed_code"] = $f->get_FieldText("snomed_code", array("value" => $r["snomed_code"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldText("status", array("value" => $r["status"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["replaced_by"] = $f->get_FieldText("replaced_by", array("value" => $r["replaced_by"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["patient_instructions"] = $f->get_FieldText("patient_instructions", array("value" => $r["patient_instructions"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["duration_minutes"] = $f->get_FieldText("duration_minutes", array("value" => $r["duration_minutes"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["requires_consent"] = $f->get_FieldText("requires_consent", array("value" => $r["requires_consent"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["notes"] = $f->get_FieldText("notes", array("value" => $r["notes"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_by"] = $f->get_FieldText("created_by", array("value" => $r["created_by"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_by"] = $f->get_FieldText("updated_by", array("value" => $r["updated_by"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_by"] = $f->get_FieldText("deleted_by", array("value" => $r["deleted_by"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] =$f->get_Submit("submit", array("value" =>lang("App.Edit"),"proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["mstudy"].$f->fields["loinc_code"].$f->fields["short_name"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["long_name"].$f->fields["common_name"].$f->fields["coding_system"])));
$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["code_version"].$f->fields["category"].$f->fields["subcategory"])));
$f->groups["g4"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["procedure_type"].$f->fields["modality"].$f->fields["cpt_code"])));
$f->groups["g5"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["snomed_code"].$f->fields["status"].$f->fields["replaced_by"])));
$f->groups["g6"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["patient_instructions"].$f->fields["duration_minutes"].$f->fields["requires_consent"])));
$f->groups["g7"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["notes"].$f->fields["created_by"].$f->fields["updated_by"])));
$f->groups["g8"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["deleted_by"].$f->fields["created_at"].$f->fields["updated_at"])));
$f->groups["g9"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["deleted_at"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
		 "title" => lang("Iris_Mstudies.edit-title"),
		 "content" =>$f,
		 "header-back" =>$back
));
echo($card);
?>
