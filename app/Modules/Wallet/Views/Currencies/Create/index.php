<?php


use Config\Services;

$authentication = service('authentication');
$request = service('request');
/** Config **/
$d["action"] = null;
$d["singular"] = "wallet-currencies-create";
$d["module"] = "Wallet";
$d["component"] = "Currencies";
$d["namespaced"] = 'App\Modules\Wallet\Views\Currencies\Create';
$singular = $authentication->has_Permission($d["singular"]);
$submited = $request->getPost("submited");
if ($singular) {
    if (!empty($submited)) {
        $c = view($d["namespaced"] . '\validator', $d);
    } else {
        $c = view($d["namespaced"] . '\form', $d);
    }
} else {
    $c = view($d["namespaced"] . '\deny', $d);
}
/** Build **/
session()->set('page_template', 'page');
session()->set('plugin_tables', true);
session()->set('main_template', 'c9c3');
session()->set('main', $c);
session()->set('right', '');
?>
