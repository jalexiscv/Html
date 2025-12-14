<?php

/*
 * Copyright (c) 2021-2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

generate_disa_permissions();

/*
 * -----------------------------------------------------------------------------
 * [Vars]
 * -----------------------------------------------------------------------------
*/
$singular = $authentication->has_Permission('disa-access');
$submited = $request->getPost("submited");
/*
 * -----------------------------------------------------------------------------
 * [Evaluate]
 * -----------------------------------------------------------------------------
*/
$data = $parent->get_Array();
$c = view('App\Modules\Disa\Views\Mipg\Enter\view', $data);
/*
 * -----------------------------------------------------------------------------
 * [Build]
 * -----------------------------------------------------------------------------
*/
session()->set('page_template', 'page');
session()->set('main_template', 'c9c3');
session()->set('messenger', false);
session()->set('main', $c);
session()->set('right', '');

?>