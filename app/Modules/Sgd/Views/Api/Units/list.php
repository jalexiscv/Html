<?php

$munits = model('App\Modules\Sgd\Models\Sgd_Units');

$units = $munits->get_SelectData($oid);
echo(json_encode($units));

?>