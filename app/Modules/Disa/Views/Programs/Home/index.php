<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
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
$data['permissions'] = array('singular' => false, "plural" => 'disa-programs-view-all');
$plural = $authentication->has_Permission($data['permissions']['plural']);
$submited = $request->getPost("submited");
$validator = $component . '\validator';
$list = $component . '\view';
$deny = $component . '\deny';
$score = $component . '\score';

/*
* -----------------------------------------------------------------------------
* [Evaluate]
* -----------------------------------------------------------------------------
*/
if ($plural) {
    if (!empty($submited)) {
        $c = view($validator, $data);
    } else {
        $c = view($list, $data);
    }
} else {
    $c = view($deny, $data);
}


/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$header = view($component . '\breadcrumb', $data);
session()->set('page_template', 'page');
session()->set('page_header', $header);
session()->set('main_template', 'c8c4');
session()->set('messenger', true);
session()->set('main', $c);
session()->set('right', view($score, $data));

?>