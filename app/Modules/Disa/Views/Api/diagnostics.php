<?php
/*
 * Copyright (c) 2021. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */
$request = service("request");
$politic = $request->getVar("politic");
$mdiagnostics = model('App\Modules\Disa\Models\Disa_Diagnostics');
$diagnostics = $mdiagnostics->get_SelectData($politic);
foreach ($diagnostics as $key => $value) {
    $value["label"] = urldecode($value["label"]);
    $diagnostics[$key] = $value;
}
echo(json_encode($diagnostics));

?>