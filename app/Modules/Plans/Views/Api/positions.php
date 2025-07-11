<?php

/** @var string $oid */

$mpositions = model('App\Modules\Plans\Models\Plans_Positions');
$positions = $mpositions->get_SelectDataWithPosition($oid);

$json = json_encode($positions);
echo($json);

?>