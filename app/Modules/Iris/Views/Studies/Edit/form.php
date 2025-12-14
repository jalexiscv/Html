<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-04-10 06:52:22
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Studies\Editor\form.php]
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
$f = service("forms",array("lang" => "Iris_Studies."));
//[models]--------------------------------------------------------------------------------------------------------------
//$model = model("App\Modules\Iris\Models\Iris_Studies");
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
$row= $model->getStudy($oid);
$r["study"] = $f->get_Value("study",$row["study"]);
$r["episode"] = $f->get_Value("episode",$row["episode"]);
$r["study_date"] = $f->get_Value("study_date",$row["study_date"]);
$r["study_type"] = $f->get_Value("study_type",$row["study_type"]);
$r["status"] = $f->get_Value("status",$row["status"]);
$r["observations"] = $f->get_Value("observations",$row["observations"]);
$r["author"] = $f->get_Value("author",safe_get_user());
$r["created_at"] = $f->get_Value("created_at",$row["created_at"]);
$r["updated_at"] = $f->get_Value("updated_at",$row["updated_at"]);
$r["deleted_at"] = $f->get_Value("deleted_at",$row["deleted_at"]);
$back=$f->get_Value("back",$server->get_Referer());
$studies = [
	["label" => lang("Iris.Diabetic Retinopathy Screening"), "value" => "DIABETIC_RETINOPATHY"],
	["label" => lang("Iris.Age-related Macular Degeneration (AMD) Study"), "value" => "AMD"],
	["label" => lang("Iris.Glaucoma Screening"), "value" => "GLAUCOMA"],
	["label" => lang("Iris.Hypertensive Retinopathy Assessment"), "value" => "HYPERTENSIVE_RETINOPATHY"],
	["label" => lang("Iris.Ocular Ischemic Syndrome Evaluation"), "value" => "OCULAR_ISCHEMIC"],
	["label" => lang("Iris.Diabetic Macular Edema (DME) Detection"), "value" => "DME"],
	["label" => lang("Iris.Papilledema Assessment"), "value" => "PAPILLEDEMA"],
	["label" => lang("Iris.Optic Neuropathy Study"), "value" => "OPTIC_NEUROPATHY"],
	["label" => lang("Iris.Choroidal Nevus or Melanoma Monitoring"), "value" => "CHOROIDAL_MONITORING"],
	["label" => lang("Iris.Retinal Vein or Artery Occlusion Analysis"), "value" => "VASCULAR_OCCLUSION"],
	["label" => lang("Iris.Follow-up Study"), "value" => "FOLLOW_UP"],
	["label" => lang("Iris.Artificial Intelligence (AI) Validation Study"), "value" => "AI_VALIDATION"],
	["label" => lang("Iris.Quality Assurance / Image Grading Study"), "value" => "QUALITY_ASSURANCE"]
];

$statuses = [
	["label" => "Pendiente", "value" => "PENDING"],
	["label" => "En progreso", "value" => "IN_PROGRESS"],
	["label" => "Completado", "value" => "COMPLETED"],
	["label" => "Revisado", "value" => "REVIEWED"],
	["label" => "Aprobado", "value" => "APPROVED"],
	["label" => "Rechazado", "value" => "REJECTED"],
	["label" => "Cancelado", "value" => "CANCELLED"],
	["label" => "Requiere nueva captura", "value" => "NEEDS_RESCAN"],
	["label" => "Archivado", "value" => "ARCHIVED"]
];

//[fields]----------------------------------------------------------------------------------------------------------------
$f->add_HiddenField("back",$back);
$f->fields["study"] = $f->get_FieldText("study", array("value" => $r["study"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12","readonly"=>true));
$f->fields["episode"] = $f->get_FieldText("episode", array("value" => $r["episode"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12","readonly"=>true));
$f->fields["study_date"] = $f->get_FieldText("study_date", array("value" => $r["study_date"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["status"] = $f->get_FieldSelect("status", array("selected" => $r["status"],"data"=>$statuses,"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["study_type"] = $f->get_FieldSelect("study_type", array("selected" => $r["study_type"],"data"=>$studies,"proportion"=>"col-md-8 col-12"));
$f->fields["observations"] = $f->get_FieldTextArea("observations", array("value" => $r["observations"],"proportion"=>"col-12"));
$f->add_HiddenField("author",$r["author"]);
$f->fields["created_at"] = $f->get_FieldText("created_at", array("value" => $r["created_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["updated_at"] = $f->get_FieldText("updated_at", array("value" => $r["updated_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["deleted_at"] = $f->get_FieldText("deleted_at", array("value" => $r["deleted_at"],"proportion"=>"col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12"));
$f->fields["cancel"]=$f->get_Cancel("cancel", array("href" =>$back,"text" =>lang("App.Cancel"),"type"=>"secondary","proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
$f->fields["submit"] =$f->get_Submit("submit", array("value" =>lang("App.Edit"),"proportion" =>"col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
//[groups]----------------------------------------------------------------------------------------------------------------
$f->groups["g1"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["study"].$f->fields["episode"].$f->fields["study_date"])));
$f->groups["g2"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["status"].$f->fields["study_type"])));
$f->groups["g3"]=$f->get_Group(array("legend"=>"","fields"=>($f->fields["observations"])));
//[buttons]-------------------------------------------------------------------------------------------------------------
$f->groups["gy"] =$f->get_GroupSeparator();
$f->groups["gz"] = $f->get_Buttons(array("fields"=>$f->fields["submit"].$f->fields["cancel"]));
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("create", array(
		 "title" => lang("Iris_Studies.edit-title"),
		 "content" =>$f,
		 "header-back" =>$back
));
echo($card);
?>
