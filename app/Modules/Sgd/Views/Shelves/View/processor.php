<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-03-27 03:27:06
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Sgd\Views\Shelves\Editor\processor.php]
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
$f = service("forms",array("lang" => "Sgd_Shelves."));
$model = model("App\Modules\Sgd\Models\Sgd_Shelves");
$d = array(
    "shelve" => $f->get_Value("shelve"),
    "reference" => $f->get_Value("reference"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "author" => safe_get_user(),
);
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["shelve"]);
if (isset($row["shelve"])) {
//$edit = $model->update($d);
$c = $bootstrap->get_Card('warning', array(
				'class' => 'card-warning',
				'icon' => 'fa-duotone fa-triangle-exclamation',
				'text-class' => 'text-center',
				'title' => lang("Sgd_Shelves.view-success-title"),
				'text' => lang("Sgd_Shelves.view-success-message"),
				'footer-class' => 'text-center',
				'footer-continue' => base_url("/sgd/shelves/view/{$d["shelve"]}/".lpk()),
				'voice' => "sgd/shelves-view-success-message.mp3",
		));
}else {
$c = $bootstrap->get_Card('success', array(
				'class' => 'card-success',
				'icon' => 'fa-duotone fa-triangle-exclamation',
				'text-class' => 'text-center',
				'title' => lang("Sgd_Shelves.view-noexist-title"),
				'text' => lang("Sgd_Shelves.view-noexist-message"),
				'footer-class' => 'text-center',
				'footer-continue' => base_url("/sgd/shelves"),
				'voice' => "sgd/shelves-view-noexist-message.mp3",
		));
}
echo($c);
?>
