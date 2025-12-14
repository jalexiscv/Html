<?php

//[vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$data['permissions'] = array('singular' => "security-access");
$singular = $authentication->has_Permission($data['permissions']['singular']);
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$home = $component . '\view';
$deny = $component . '\deny';
//[build]---------------------------------------------------------------------------------------------------------------
if ($authentication->get_LoggedIn()) {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($home, $data),
        'right' => get_security_count_permissions() . get_security_count_roles() . get_security_count_users(),
    );
} else {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($home, $data),
        'right' => "",
    );
}
echo(json_encode($json));
?>