<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */


use Config\Services;

$request = service('request');
$mapplieds = model('App\Modules\Sie\Models\Sie_Applieds');
$authentication = service('authentication');

$product = $request->getVar("product");
$discount = $request->getVar("discount");
$status = $request->getVar("status");

if ($status == "true") {
    $mapplieds->set_Applied($discount, $product);
    $response["action"] = "insert";
} else {
    $mapplieds->delete_Applied($discount, $product);
    $response["action"] = "delete";
}

echo(json_encode($response));
?>