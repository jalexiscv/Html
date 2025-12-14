<?php


$request = service('request');
$mClientsXModules = model('App\Modules\Plex\Models\Plex_Clients_Modules');
$authentication = service('authentication');

$client = $request->getVar("client");
$module = $request->getVar("module");
$status = $request->getVar("status");
if ($status == "true") {
    $mClientsXModules
        ->insert(array(
            "authorization" => strtoupper(uniqid()),
            "client" => $client,
            "module" => $module,
            "author" => $authentication->get_User()
        ));
    $response["action"] = "insert";
} else {
    $mClientsXModules
        ->where('client', $client)
        ->where('module', $module)
        ->delete();
    $response["action"] = "delete";
}
cache()->clean();
echo(json_encode($response));
?>