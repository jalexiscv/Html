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
$component = $request->getVar("component");
$mcategories = model('App\Modules\Disa\Models\Disa_Categories');
$categories = $mcategories->get_SelectData($component);
foreach ($categories as $key => $value) {
    $value["label"] = urldecode($value["label"]);
    $categories[$key] = $value;
}
echo(json_encode($categories));

?>