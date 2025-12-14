<?php

/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */


/*
 * -----------------------------------------------------------------------------
 * [Vars]
 * -----------------------------------------------------------------------------
*/
$data = $parent->get_Array();
$data['permissions'] = array('singular' => false, "plural" => 'c4isr-settings-view-all');
$plural = $authentication->has_Permission($data['permissions']['plural']);
$submited = $request->getPost("submited");
$deny = $component . '\deny';
$header = view($component . '\breadcrumb', $data);
/*
 * -----------------------------------------------------------------------------
 * [Evaluate]
 * -----------------------------------------------------------------------------
*/
if ($plural) {
    $c = view($component . '\view', $data);
} else {
    $c = view($deny, $data);
}

/*
 * -----------------------------------------------------------------------------
 * [Build]
 * -----------------------------------------------------------------------------
*/
session()->set('page_template', 'page');
session()->set('page_header', $header);
session()->set('main_template', 'c9c3');
session()->set('messenger', true);
session()->set('main', $c);
session()->set('right', '');

?>