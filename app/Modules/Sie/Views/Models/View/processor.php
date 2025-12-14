<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-12-12 06:42:08
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sie\Views\Models\Editor\processor.php]
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
$f = service("forms",array("lang" => "Sie_Models."));
$model = model("App\Modules\Sie\Models\Sie_Models");
$d = array(
    "model" => $f->get_Value("model"),
    "code" => $f->get_Value("code"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "country" => $f->get_Value("country"),
    "regulatory_framework" => $f->get_Value("regulatory_framework"),
    "uses_credits" => $f->get_Value("uses_credits"),
    "hours_per_credit" => $f->get_Value("hours_per_credit"),
    "credit_calculation_formula" => $f->get_Value("credit_calculation_formula"),
    "requires_theoretical_hours" => $f->get_Value("requires_theoretical_hours"),
    "requires_practical_hours" => $f->get_Value("requires_practical_hours"),
    "requires_independent_hours" => $f->get_Value("requires_independent_hours"),
    "requires_total_hours" => $f->get_Value("requires_total_hours"),
    "validation_rules" => $f->get_Value("validation_rules"),
    "configuration" => $f->get_Value("configuration"),
    "is_active" => $f->get_Value("is_active"),
);
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["model"]);
if (isset($row["model"])) {
//$edit = $model->update($d);
$c = $bootstrap->get_Card('warning', array(
				'class' => 'card-warning',
				'icon' => 'fa-duotone fa-triangle-exclamation',
				'text-class' => 'text-center',
				'title' => lang("Sie_Models.view-success-title"),
				'text' => lang("Sie_Models.view-success-message"),
				'footer-class' => 'text-center',
				'footer-continue' => base_url("/sie/models/view/{$d["model"]}/".lpk()),
				'voice' => "sie/models-view-success-message.mp3",
		));
}else {
$c = $bootstrap->get_Card('success', array(
				'class' => 'card-success',
				'icon' => 'fa-duotone fa-triangle-exclamation',
				'text-class' => 'text-center',
				'title' => lang("Sie_Models.view-noexist-title"),
				'text' => lang("Sie_Models.view-noexist-message"),
				'footer-class' => 'text-center',
				'footer-continue' => base_url("/sie/models"),
				'voice' => "sie/models-view-noexist-message.mp3",
		));
}
echo($c);
?>
