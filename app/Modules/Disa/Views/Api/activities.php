<?php
/*
 * Copyright (c) 2021-2022. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

use App\Libraries\Strings;

$request = service("request");
$category = $request->getVar("category");
$mactivities = model('App\Modules\Disa\Models\Disa_Activities');
$activities = $mactivities->get_SelectData($category);
foreach ($activities as $key => $value) {
    $value["label"] = urldecode($value["label"]);
    $activities[$key] = $value;
}
echo(json_encode($activities));

?>