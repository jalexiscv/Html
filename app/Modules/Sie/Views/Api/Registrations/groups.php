<?php
$request = service('request');
$mgroups = model("App\Modules\Sie\Models\Sie_Groups");


$institution = $oid;

$groups = $mgroups->getSelectData($institution);

if (is_array($groups)) {
    echo(json_encode($groups));
} else {
    echo(json_encode(array()));
}

?>