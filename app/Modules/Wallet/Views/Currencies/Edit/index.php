<?php


use Config\Services;

$authentication = service('authentication');
$request = service('request');
$model = model("App\Modules\Wallet\Models\Wallet_Currencies");
/** Config **/
$d["action"] = null;
$d["singular"] = "wallet-currencies-edit";
$d["plural"] = "wallet-currencies-edit-all";
$d["module"] = "Wallet";
$d["component"] = "Currencies";
$d["namespaced"] = 'App\Modules\Wallet\Views\Currencies\Edit';
$singular = $authentication->has_Permission($d["singular"]);
$plural = $authentication->has_Permission($d["plural"]);
$author = $model->get_Authority($id, $authentication->get_User());
$authority = ($singular && $author) ? true : false;
$submited = $request->getPost("submited");
if ($plural || $authority) {
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
