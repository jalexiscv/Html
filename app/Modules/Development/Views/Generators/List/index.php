<?php
$data = $parent->get_Array();
$data['permissions'] = array('singular' => 'nexus-access', "plural" => false);
$singular = $authentication->has_Permission($data['permissions']['singular']);
//$plural=$authentication->has_Permission($data['permissions']['plural']);
//$author= $model->get_Authority($oid,$authentication->get_User());
//$authority= $singular && $author;
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$list = $component . '\grid';
$deny = $component . '\deny';
//[build]---------------------------------------------------------------------------------------------------------------
if ($singular) {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($list, $data),
        'right' => "",
    );
} else {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($list, $data),
        'right' => "",
    );
}
echo(json_encode($json));
?>