<?php
/*
 * Copyright (c) 2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */


use Config\Services;

$request = service('request');
$authentication = service('authentication');

$model = model("\App\Modules\Disa\Models\Disa_Furag", true);
$sigep = str_pad($request->getVar("sigep"), 4, "0", STR_PAD_LEFT);
$row = $model->find($sigep);

$response = array(
    'status' => "202",
    'sigep' => $sigep,
    'message' => array(
        'data' => $row
    )
);

echo(json_encode($response));
?>