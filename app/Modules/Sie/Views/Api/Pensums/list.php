<?php
/** @var string $oid program */
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$pensum = $mpensums->get_SelectDataReturnModule($oid);
$json = json_encode(array(
    "data" => $pensum
));
echo($json);
?>