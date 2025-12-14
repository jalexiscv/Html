<?php
$mpositions = model('App\Modules\Mipg\Models\Mipg_Positions');
$positions = $mpositions->get_SelectData($oid);
print_r($positions);
$json = json_encode($positions);
echo($json);
?>