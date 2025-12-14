<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */


$request = service('request');
$mhierarchies = model("App\Modules\Security\Models\Security_Hierarchies");
$authentication = service('authentication');

$user = $request->getVar("user");
$rol = $request->getVar("rol");
$status = $request->getVar("status");
if ($status == "true") {
    $mhierarchies->set_Hierarchy($user, $rol);
    $response["action"] = "insert";
} else {
    $mhierarchies->delete_Hierarchy($user, $rol);
    $response["action"] = "delete";
}

echo(json_encode($response));
?>