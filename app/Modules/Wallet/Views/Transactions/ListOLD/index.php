<?php


use Config\Services;

$authentication = service('authentication');
$request = service('request');
/** Config **/
$d["action"] = null;
$d["plural"] = "wallet-transactions-view-all";
$d["module"] = "Wallet";
$d["component"] = "Transactions";
$d["namespaced"] = 'App\Modules\Wallet\Views\Transactions\List';
$plural = $authentication->has_Permission($d["plural"]);
if ($plural) {
    $c = view($d["namespaced"] . '\list', $d);
} else {
    $c = view($d["namespaced"] . '\deny', $d);
}
/** Build **/
session()->set('page_template', 'page');
session()->set('plugin_tables', true);
session()->set('main_template', 'c12');
session()->set('main', $c);
session()->set('right', '');
?>
