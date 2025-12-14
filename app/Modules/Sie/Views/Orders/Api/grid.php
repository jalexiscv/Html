<?php

$request = service('request');
$grid = view('App\Modules\Sie\Views\Students\View\Tabs\Finance\grid', array("oid" => $oid));
echo($grid);

?>
