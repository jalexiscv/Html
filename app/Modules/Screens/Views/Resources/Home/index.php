<?php
$data = $parent->get_Array();
$header = $component . '\breadcrumb';
/*
 * -----------------------------------------------------------------------------
 * [Vars]
 * -----------------------------------------------------------------------------
*/
$singular = $authentication->has_Permission('Screens-access');
$submited = $request->getPost("submited");
/*
 * -----------------------------------------------------------------------------
 * [Evaluate]
 * -----------------------------------------------------------------------------
*/
$data = $parent->get_Array();
$c = view('App\Modules\Screens\Views\Resources\Home\view', $data);
/*
 * -----------------------------------------------------------------------------
 * [Build]
 * -----------------------------------------------------------------------------
*/
session()->set('page_template', 'page');
session()->set('page_header', view($header, $data));
session()->set('main_template', 'c9c3');
session()->set('messenger', false);
session()->set('main', $c);
session()->set('right', '');

?>