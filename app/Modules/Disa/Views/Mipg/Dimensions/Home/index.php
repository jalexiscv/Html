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
$data['permissions'] = array('singular' => false, "plural" => "disa-dimensions-view-all");
$plural = $authentication->has_Permission($data['permissions']['plural']);
$submited = $request->getPost("submited");
/*
 * -----------------------------------------------------------------------------
 * [Evaluate]
 * -----------------------------------------------------------------------------
*/

if ($authentication->get_LoggedIn()) {
    if ($plural) {
        $c = view($component . '\view', $data);
    } else {
        $c = view($component . '\deny', $data);
    }
} else {
    $c = view($component . '\deny', $data);
}

//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "DISA",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "DIMENSIONS",
    "log" => "El usuario accede a la <a href=\"/disa/mipg/dimensions/home/{$oid}\" target==\"_blank\">vista principal de las dimensiones<a> activas en el Módulo MiPG",
));


/*
 * -----------------------------------------------------------------------------
 * [Build]
 * -----------------------------------------------------------------------------
*/
$header = view($component . '\breadcrumb', $data);
$scores = view($component . '\scores', $data);
session()->set('page_template', 'page');
session()->set('page_header', $header);
session()->set('main_template', 'c9c3');
session()->set('messenger', true);
session()->set('main', $c);
session()->set('right', $scores);
?>