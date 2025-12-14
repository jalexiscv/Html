<?php
$mservices = model("App\Modules\Helpdesk\Models\Helpdesk_Services");
$magents = model("App\Modules\Helpdesk\Models\Helpdesk_Agents");
$mfields = model("App\Modules\Helpdesk\Models\Helpdesk_Users_Fields");
$mtypes = model("App\Modules\Helpdesk\Models\Helpdesk_Types");

$service = $mservices->where("service", $oid)->first();
$agents = $magents->where("service", $oid)->findAll();
$types = $mtypes->where("service", $oid)->findAll();

$result = array();
$result["direct"] = $service["direct"];
$result["count"] = 0;
function compararPorLabel($a, $b)
{
    return strcmp($a["label"], $b["label"]);
}

if (is_array($agents)) {
    $result["count"] = count($agents);
    $jagents = array();
    foreach ($agents as $agent) {
        $profile = $mfields->get_Profile($agent["user"]);
        $name = $profile["name"];
        $jagents[] = array("label" => $name, "value" => $agent["user"]);
        usort($jagents, 'compararPorLabel');
    }
    $result["agents"] = $jagents;
} else {
    $result["count"] = 0;
    $result["agents"] = array();
}

$jtypes = array();
foreach ($types as $type) {
    $name = $type["name"];
    $jtypes[] = array("label" => $name, "value" => $type["type"]);
    usort($jtypes, 'compararPorLabel');
}
$result["types"] = $jtypes;

echo(json_encode($result));

?>