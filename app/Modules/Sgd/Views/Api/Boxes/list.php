<?php

$mboxes = model('App\Modules\Sgd\Models\Sgd_Boxes');

$boxes = $mboxes->get_SelectData($oid);
echo(json_encode($boxes));

?>