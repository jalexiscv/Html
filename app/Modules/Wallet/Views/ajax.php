<?php
//header("Content-Type: application/json; charset=UTF-8");
$data = array(
    "view" => $view,
    "id" => isset($id) ? $id : false
);
$src = 'App\Modules\Wallet\Views';
switch ($view) {
    case "wallet-currencies-ajax-list":
        $c = view($src . '\Currencies\List\ajax', $data);
        break;
    case "wallet-transactions-ajax-list":
        $c = view($src . '\Transactions\List\ajax', $data);
        break;
    case "wallet-acounts-ajax-users":
        $c = view($src . '\Acounts\Ajax\users', $data);
        break;
    default:
        $c = view("App\Modules\Wallet\Views\E404\ajax", $data);
        break;
}
echo($c);
?>