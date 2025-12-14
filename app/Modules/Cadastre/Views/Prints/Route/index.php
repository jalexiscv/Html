<?php
$bootstrap = service('bootstrap');
//[Vars]----------------------------------------------------------------------------------------------------------------
$data = $parent->get_Array();
$data['permissions'] = array('singular' => "cadastre-access");
$singular = $authentication->has_Permission($data['permissions']['singular']);
$submited = $request->getPost("submited");
$breadcrumb = $component . '\breadcrumb';
$validator = $component . '\validator';
$home = $component . '\view';
$deny = $component . '\deny';
$routes = $component . '\routes';
//[build]---------------------------------------------------------------------------------------------------------------
if ($authentication->get_LoggedIn()) {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($home, $data),
        'right' => view($routes, $data)
    );
} else {
    $json = array(
        'breadcrumb' => view($breadcrumb, $data),
        'main' => view($deny, $data),
        'right' => "");
}
echo(json_encode($json));
?>