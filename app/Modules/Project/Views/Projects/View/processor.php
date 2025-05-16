<?php

/**
 * █ ---------------------------------------------------------------------------------------------------------------------
 * █ ░FRAMEWORK                                  2025-04-28 04:55:12
 * █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Project\Views\Projects\Editor\processor.php]
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
$f = service("forms", array("lang" => "Project_Projects."));
$model = model("App\Modules\Project\Models\Project_Projects");
$d = array(
    "project" => $f->get_Value("project"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "start" => $f->get_Value("start"),
    "end" => $f->get_Value("end"),
    "status" => $f->get_Value("status"),
    "budget" => $f->get_Value("budget"),
    "responsible" => $f->get_Value("responsible"),
    "priority" => $f->get_Value("priority"),
    "comments" => $f->get_Value("comments"),
    "author" => safe_get_user(),
    "estimated_end_date" => $f->get_Value("estimated_end_date"),
);
//[build]---------------------------------------------------------------------------------------------------------------
$row = $model->find($d["project"]);
if (isset($row["project"])) {
//$edit = $model->update($d);
    $c = $bootstrap->get_Card('warning', array(
        'class' => 'card-warning',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Project_Projects.view-success-title"),
        'text' => lang("Project_Projects.view-success-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/project/projects/view/{$d["project"]}/" . lpk()),
        'voice' => "project/projects-view-success-message.mp3",
    ));
} else {
    $c = $bootstrap->get_Card('success', array(
        'class' => 'card-success',
        'icon' => 'fa-duotone fa-triangle-exclamation',
        'text-class' => 'text-center',
        'title' => lang("Project_Projects.view-noexist-title"),
        'text' => lang("Project_Projects.view-noexist-message"),
        'footer-class' => 'text-center',
        'footer-continue' => base_url("/project/projects"),
        'voice' => "project/projects-view-noexist-message.mp3",
    ));
}
echo($c);
?>
