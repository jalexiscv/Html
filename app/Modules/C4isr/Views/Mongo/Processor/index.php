<?php
/*
 * Copyright (c) 2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
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
$data['model'] = model("App\Modules\C4isr\Models\C4isr_Cases");
$data['permissions'] = array('singular' => 'c4isr-access');
$singular = $authentication->has_Permission($data['permissions']['singular']);
$submited = $request->getPost("submited");
$header = $component . '\breadcrumb';
$validator = $component . '\validator';
$form = $component . '\form';
$deny = $component . '\deny';
/*
* -----------------------------------------------------------------------------
* [Evaluate]
* -----------------------------------------------------------------------------
*/
if ($singular) {
    if (!empty($submited)) {
        $c = view($validator, $data);
    } else {
        $c = view($form, $data);
    }
} else {
    $c = view($deny, $data);
}
/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/

session()->set('page_template', 'page');
session()->set('page_header', view($header, $data));
session()->set('main_template', 'c9c3');
session()->set('right', '');
session()->set('messenger', true);
session()->set('main', $c);
?>