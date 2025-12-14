<?php

$mseries= model('App\Modules\Sgd\Models\Sgd_Series');

$series = $mseries->get_SelectData($oid);
echo(json_encode($series));

?>