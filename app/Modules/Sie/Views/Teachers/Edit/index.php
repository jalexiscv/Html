<?php

//[vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$data['model'] = model("App\Modules\Security\Models\Security_Users");
$data['permissions'] = array('singular' => 'SIE-STUDENTS-EDIT', "plural" => 'SIE-STUDENTS-EDIT-ALL');
$singular = $authentication->has_Permission($data['permissions']['singular']);
$plural = $authentication->has_Permission($data['permissions']['plural']);
$author = $data['model']->get_Authority($oid, safe_get_user());
$authority = ($singular && $author) ? true : false;
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$form = $component . '\tabs';
$deny = $component . '\deny';
$photo = $component . '\photo';
//[build]---------------------------------------------------------------------------------------------------------------
if ($plural || $authority) {
    if (!empty($submited)) {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($validator, $data),
            'right' => ""
        );
    } else {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($form, $data),
            'right' => view($photo, $data)
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