<?php


$request = service('request');
$mpolicies = model("App\Modules\Security\Models\Security_Policies");
$authentication = service('authentication');

$rol = $request->getVar("rol");
$permission = $request->getVar("permission");
$status = $request->getVar("status");
if ($status == "true") {
    $mpolicies->set_Policy($rol, $permission);
    $response["action"] = "insert";
} else {
    $mpolicies->delete_Policy($rol, $permission);
    $response["action"] = "delete";
}
echo(json_encode($response));
?>