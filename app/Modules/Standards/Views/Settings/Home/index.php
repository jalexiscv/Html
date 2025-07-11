<?php

//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
$data = $parent->get_Array();
$data['permissions'] = array('singular' => "sgd-access");
$singular = $authentication->has_Permission($data['permissions']['singular']);
$submited = $request->getPost("submited");
$breadcrumb = $component . '\Home\breadcrumb';
$validator = $component . '\Home\validator';
$home = $component . '\Home\view';
$deny = $component . '\Home\deny';
//[build]---------------------------------------------------------------------------------------------------------------
$json = array(
    'breadcrumb' => view($breadcrumb, $data),
    'main' => view($home, $data),
    'right' => "",
);
echo(json_encode($json));
?>