<?php
//[vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$data['permissions'] = array('singular' => false, "plural" => 'security-roles-view-all');
$plural = $authentication->has_Permission($data['permissions']['plural']);
$submited = $request->getPost("submited");
$validator = $component . '\validator';
$list = $component . '\table';
$deny = $component . '\deny';
$breadcrumb = $component . '\breadcrumb';
$right = get_security_count_roles();
//[build]---------------------------------------------------------------------------------------------------------------
if ($plural) {
    if (!empty($submited)) {
        $json = array('breadcrumb' => view($breadcrumb, $data), 'main' => view($validator, $data), 'right' => "");
    } else {
        $json = array('breadcrumb' => view($breadcrumb, $data), 'main' => view($list, $data), 'right' => $right);
    }
} else {
    $json = array('breadcrumb' => view($breadcrumb, $data), 'main' => view($deny, $data), 'right' => "");
}
echo(json_encode($json));
?>