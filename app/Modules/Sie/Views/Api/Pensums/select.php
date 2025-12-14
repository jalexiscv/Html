<?php
/** @var string $oid program */
$mpensums = model('App\Modules\Sie\Models\Sie_Pensums');
$pensums = $mpensums->get_SelectData($oid);
$json = json_encode(array(
    "data" => $pensums
));
echo($json);
?>