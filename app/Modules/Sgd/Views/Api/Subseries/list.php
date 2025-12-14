<?php

$msubseries= model('App\Modules\Sgd\Models\Sgd_Subseries');

$series = $msubseries->get_SelectData($oid);
echo(json_encode($series));

?>