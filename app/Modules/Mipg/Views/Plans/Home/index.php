<?php

//[vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$data['permissions'] = array('singular' => "plans-access");
$singular = $authentication->has_Permission($data['permissions']['singular']);
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$home = $component . '\view';
$deny = $component . '\deny';
$tree = $component . '\tree';
//[build]---------------------------------------------------------------------------------------------------------------
$json = array(
    'breadcrumb' => view($breadcrumb, $data),
    'main' => view($home, $data),
    'right' => view($tree, $data),
);
echo(json_encode($json));
?>