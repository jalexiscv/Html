<?php

$msettings = model('App\Modules\Sie\Models\Sie_Settings');
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

$status = $msettings->getSetting("G-S");


$data = $parent->get_Array();
$data['permissions'] = array('singular' => 'sie-graduations-create', "plural" => false);
$singular = $authentication->has_Permission($data['permissions']['singular']);
$submited = $request->getPost("submited");
$validator = $component . '\validator';
$breadcrumb = $component . '\breadcrumb';
$form = $component . '\form';
$deny = $component . '\deny';
$disabled = $component . '\disabled';
//[build]---------------------------------------------------------------------------------------------------------------
if ($singular || $status["value"] == "ACTIVE") {
    if (!empty($submited)) {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($validator, $data),
            'right' => "",
            'main_template' => 'c8c4',//'c12',
        );
    } else {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($form, $data),
            'right' => "",
            'main_template' => 'c8c4',//'c12',
        );
    }
} else {
    if ($status["value"] == "DISABLED") {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($disabled, $data),
            'right' => "",
            'main_template' => 'c8c4',
        );
    } else {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($deny, $data),
            'right' => "",
            'main_template' => 'c8c4',
        );
    }
}
echo(json_encode($json));
?>