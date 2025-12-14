<?php

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
$data = $parent->get_Array();
$data['permissions'] = array('singular' => false, "plural" => 'sie-graduations-view-all');
$plural = $authentication->has_Permission($data['permissions']['plural']);
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$table = $component . '\grid';
$deny = $component . '\deny';
//[build]---------------------------------------------------------------------------------------------------------------
if ($plural) {
    if (!empty($submited)) {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($validator, $data),
            'right' => ""
        );
    } else {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($table, $data),
            'right' => ""
        );
    }
} else {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($deny, $data),
        'right' => ""
    );
}
echo(json_encode($json));
?>