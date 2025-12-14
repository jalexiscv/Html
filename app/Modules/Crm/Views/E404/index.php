<?php

//[vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$data['permissions'] = array('singular' => "crm-access");
$singular = $authentication->has_Permission($data['permissions']['singular']);
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$home = "{$module}\\Views\\E404\\view";
//[build]---------------------------------------------------------------------------------------------------------------
$json = array(
    'breadcrumb' => view($breadcrumb, $data),
    'main' => view($home, $data),
    'right' => "",
);
echo(json_encode($json));
?>