<?php
$request = service("request");
$msettings = model('App\Modules\Security\Models\Security_Settings');
$option = $request->getVar("option");
$value = $request->getVar("value");
if ($option == "autoregister") {
    $d = array(
        "setting" => pk(),
        "name" => "autoregister",
        "value" => $value,
        "author" => safe_get_user(),
    );
    $row = $msettings->insert($d);
    $response = array(
        "option" => $option,
        "status" => "success",
        "updated" => time(),
    );
    $msettings->clear_Cache("setting-autoregister");
} elseif ($option == "2fa") {
    $d = array(
        "setting" => pk(),
        "name" => "2fa",
        "value" => $value,
        "author" => safe_get_user(),
    );
    $row = $msettings->insert($d);
    $response = array(
        "option" => $option,
        "status" => "success",
        "updated" => time(),
    );
    $msettings->clear_Cache("setting-2fa");
} else {
    $response = array(
        "option" => $option,
        "status" => "error",
        "updated" => time(),
    );
}
echo(json_encode($response));
?>