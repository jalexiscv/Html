<?php

//[Vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$form = $component . '\form';
//[Build]---------------------------------------------------------------------------------------------------------------
$right = "";
//[build]---------------------------------------------------------------------------------------------------------------
if (!empty($submited)) {
    $json = array(
        'main_template' => 'c0',
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($validator, $data),
        'right' => $right
    );
} else {
    $json = array(
        'main_template' => 'c0',
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($form, $data),
        'right' => $right
    );
}
echo(json_encode($json));
?>