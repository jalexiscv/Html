<?php

$main = "<h2>e404</h2>";
$main .= "<br><b>View</b>: {$view}";
$main .= "<br><b>Id</b>: {$oid}";

session()->set('page_template', 'page');
session()->set('main_template', 'c8c4');
session()->set('main', $main);
session()->set('right', "RIGHT");

?>