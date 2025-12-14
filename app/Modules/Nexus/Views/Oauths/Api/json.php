<?php

/*
* -----------------------------------------------------------------------------
* [Requests]
* -----------------------------------------------------------------------------
*/
$request = service('request');

$client = $request->getPost("client");
$oauth = $request->getPost("oauth");
$mdatas = model("App\Modules\Nexus\Models\Nexus_Datas");

if ($oid == "create") {
    $id = $request->getPost("id");
    $key = $request->getPost("key");
    $did = array("data" => pk(), "reference" => $client, "name" => "{$oauth}-id", "value" => $id);
    $dkey = array("data" => pk(), "reference" => $client, "name" => "{$oauth}-key", "value" => $key);
    $create = $mdatas->insert($did);
    $create = $mdatas->insert($dkey);
    $json["id"] = $id;
    $json["key"] = $key;
} elseif ($oid == "check") {
    $status = $request->getPost("status");
    $dstatus = array("data" => pk(), "reference" => $client, "name" => "{$oauth}-status", "value" => $status);
    $create = $mdatas->insert($dstatus);
}

/*
* -----------------------------------------------------------------------------
* [Build]
* -----------------------------------------------------------------------------
*/
$json["oid"] = $oid;
$json["option"] = $option;
$json["oauth"] = $oauth;
$json["client"] = $client;
$json["message"] = "200";
echo(json_encode($json));
?>