<?php
/** @var array $data */
/** @var $parent */
/** @var $authentication */
/** @var $request */
/** @var $component */

$data = $parent->get_Array();
$data['permissions'] = array('singular' => 'settings-access');
$singular = $authentication->has_Permission($data['permissions']['singular']);
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$form = $component . '\form';
$deny = $component . '\deny';
//[build]---------------------------------------------------------------------------------------------------------------
if ($authentication->get_LoggedIn()) {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($form, $data),
        'right' => "",
    );
} else {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($deny, $data),
        'right' => "",
    );
}
//[print]---------------------------------------------------------------------------------------------------------------
echo(json_encode($json));
?>