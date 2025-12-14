<?php

/**
* █ ---------------------------------------------------------------------------------------------------------------------
* █ ░FRAMEWORK                                  2025-04-08 11:56:24
* █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Maintenance\Views\Sheets\Editor\processor.php]
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
$f = service("forms",array("lang" => "Maintenance_Sheets."));
$model = model("App\Modules\Maintenance\Models\Maintenance_Sheets");
$d = array(
    "sheet" => $f->get_Value("sheet"),
    "asset" => $f->get_Value("asset"),
    "name" => $f->get_Value("name"),
    "value" => $f->get_Value("value"),
    "author" => safe_get_user(),
);
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["sheet"]);
if (isset($row["sheet"])) {
//$edit = $model->update($d);
$c = $bootstrap->get_Card('warning', array(
				'class' => 'card-warning',
				'icon' => 'fa-duotone fa-triangle-exclamation',
				'text-class' => 'text-center',
				'title' => lang("Maintenance_Sheets.view-success-title"),
				'text' => lang("Maintenance_Sheets.view-success-message"),
				'footer-class' => 'text-center',
				'footer-continue' => base_url("/maintenance/sheets/view/{$d["sheet"]}/".lpk()),
				'voice' => "maintenance/sheets-view-success-message.mp3",
		));
}else {
$c = $bootstrap->get_Card('success', array(
				'class' => 'card-success',
				'icon' => 'fa-duotone fa-triangle-exclamation',
				'text-class' => 'text-center',
				'title' => lang("Maintenance_Sheets.view-noexist-title"),
				'text' => lang("Maintenance_Sheets.view-noexist-message"),
				'footer-class' => 'text-center',
				'footer-continue' => base_url("/maintenance/sheets"),
				'voice' => "maintenance/sheets-view-noexist-message.mp3",
		));
}
echo($c);
?>
