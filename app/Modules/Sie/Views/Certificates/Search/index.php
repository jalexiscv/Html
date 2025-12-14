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
$data['model'] = model("App\Modules\Sie\Models\Sie_Certificates");
$data['permissions'] = array('singular' => 'sie-certificates-view', "plural" => 'sie-certificates-view-all');
$singular = $authentication->has_Permission($data['permissions']['singular']);
$plural = $authentication->has_Permission($data['permissions']['plural']);
$author = $data['model']->get_Authority($oid, safe_get_user());
$authority = ($singular && $author) ? true : false;
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$form = $component . '\form';
$deny = $component . '\deny';
//[build]---------------------------------------------------------------------------------------------------------------
if (!empty($submited)) {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($validator, $data),
        'right' => "",
        'main_template' => 'c9c3',//'c12',
    );
} else {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($form, $data),
        'right' => "",
        'main_template' => 'c9c3',//'c12',
    );
}
echo(json_encode($json));
?>