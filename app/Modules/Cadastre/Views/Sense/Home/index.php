<?php

generate_cadastre_permissions();
/*
* -----------------------------------------------------------------------------
* [Vars]
* -----------------------------------------------------------------------------
*/
$data = $parent->get_Array();
$data['permissions'] = array('singular' => "cadastre-access");
$singular = $authentication->has_Permission($data['permissions']['singular']);
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$home = $component . '\view';
$processor = $component . '\processor';
$deny = $component . '\deny';
//[build]---------------------------------------------------------------------------------------------------------------
if ($singular) {
    if (!empty($submited)) {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($processor, $data),
            'right' => get_snippet_profiles_history($oid));
    } else {
        $json = array(
            'breadcrumb' => view($breadcrumb, $data),
            'main' => view($home, $data),
            'right' => get_snippet_profiles_history($oid));
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