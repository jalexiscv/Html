<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-10-03 06:59:59
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Iris\Views\Mstudies\Editor\processor.php]
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
$authentication =service('authentication');
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
$f = service("forms",array("lang" => "Iris_Mstudies."));
$model = model("App\Modules\Iris\Models\Iris_Mstudies");
$d = array(
    "mstudy" => $f->get_Value("mstudy"),
    "loinc_code" => $f->get_Value("loinc_code"),
    "short_name" => $f->get_Value("short_name"),
    "long_name" => $f->get_Value("long_name"),
    "common_name" => $f->get_Value("common_name"),
    "coding_system" => $f->get_Value("coding_system"),
    "code_version" => $f->get_Value("code_version"),
    "category" => $f->get_Value("category"),
    "subcategory" => $f->get_Value("subcategory"),
    "procedure_type" => $f->get_Value("procedure_type"),
    "modality" => $f->get_Value("modality"),
    "cpt_code" => $f->get_Value("cpt_code"),
    "snomed_code" => $f->get_Value("snomed_code"),
    "status" => $f->get_Value("status"),
    "replaced_by" => $f->get_Value("replaced_by"),
    "patient_instructions" => $f->get_Value("patient_instructions"),
    "duration_minutes" => $f->get_Value("duration_minutes"),
    "requires_consent" => $f->get_Value("requires_consent"),
    "notes" => $f->get_Value("notes"),
    "created_by" => $f->get_Value("created_by"),
    "updated_by" => $f->get_Value("updated_by"),
    "deleted_by" => $f->get_Value("deleted_by"),
);
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["mstudy"]);
if (isset($row["mstudy"])) {
//$edit = $model->update($d);
$c = $bootstrap->get_Card('warning', array(
				'class' => 'card-warning',
				'icon' => 'fa-duotone fa-triangle-exclamation',
				'text-class' => 'text-center',
				'title' => lang("Iris_Mstudies.view-success-title"),
				'text' => lang("Iris_Mstudies.view-success-message"),
				'footer-class' => 'text-center',
				'footer-continue' => base_url("/iris/mstudies/view/{$d["mstudy"]}/".lpk()),
				'voice' => "iris/mstudies-view-success-message.mp3",
		));
}else {
$c = $bootstrap->get_Card('success', array(
				'class' => 'card-success',
				'icon' => 'fa-duotone fa-triangle-exclamation',
				'text-class' => 'text-center',
				'title' => lang("Iris_Mstudies.view-noexist-title"),
				'text' => lang("Iris_Mstudies.view-noexist-message"),
				'footer-class' => 'text-center',
				'footer-continue' => base_url("/iris/mstudies"),
				'voice' => "iris/mstudies-view-noexist-message.mp3",
		));
}
echo($c);
?>
