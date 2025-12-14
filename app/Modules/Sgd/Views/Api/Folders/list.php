<?php

$mfolders = model('App\Modules\Sgd\Models\Sgd_Folders');

$folders = $mfolders->get_SelectData($oid);
echo(json_encode($folders));

?>