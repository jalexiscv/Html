<?php


use Config\Services;

$authentication = service('authentication');
$request = service('request');
/** Config **/
$d["action"] = null;
$d["plural"] = "wallet-currencies-view-all";
$d["module"] = "Wallet";
$d["component"] = "Currencies";
$d["namespaced"] = 'App\Modules\Wallet\Views\Currencies\List';
$plural = $authentication->has_Permission($d["plural"]);
if ($plural) {
    $c = view($d["namespaced"] . '\list', $d);
} else {
    $c = view($d["namespaced"] . '\deny', $d);
}
/** Build **/
session()->set('page_template', 'page');
session()->get('page_header') = view($d["namespaced"] . '\breadcrumb', $d);
session()->set('plugin_tables', true);
session()->set('main_template', 'c9c3');
session()->set('main', $c);
session()->set('right', '');
?>
