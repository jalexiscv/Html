<?php

/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

$data = $parent->get_Array();
$data['permissions'] = array('singular' => 'social-settings-view', "plural" => 'social-settings-view-all');
$singular = $authentication->has_Permission($data['permissions']['singular']);
$plural = $authentication->has_Permission($data['permissions']['plural']);
$validator = $component . '\validator';
$options = $component . '\options';
$denied = $component . '\denied';
$submited = $request->getPost("submited");


if ($singular) {
    if (!empty($submited)) {
        $c = view($validator, $data);
    } else {
        $c = view($options, $data);
    }
} else {
    $c = view($denied, $data);
}


/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$header = view($component . '\breadcrumb', array());
session()->set('page_template', "page");
session()->set('page_header', $header);
session()->set('main_template', "c9c3");
session()->set('messenger', true);
session()->set('main', $c);
session()->set('right', "");

?>