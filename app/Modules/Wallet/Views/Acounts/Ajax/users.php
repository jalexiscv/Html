<?php
$musers = model('App\Modules\Wallet\Models\Wallet_Users');
$mfields = model('App\Modules\Wallet\Models\Wallet_Users_Fields');
$users = $musers->like("user", $id)->find();

$json = array();
foreach ($users as $user) {
    $alias = $mfields->get_Field($user["user"], "alias");
    array_push($json, array("value" => $user["user"], "label" => "{$user["user"]} - {$alias}"));
}

echo(json_encode($json));
?>