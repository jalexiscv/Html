<?php

$mshelves = model('App\Modules\Sgd\Models\Sgd_Shelves');

$shelves = $mshelves->get_SelectData($oid);
echo(json_encode($shelves));

?>