<?php

$mcenters = model('App\Modules\Sgd\Models\Sgd_Centers');
$center= $mcenters->getCenter($oid);

$b = service("bootstrap");
$menu = array(
    array("href" => "/sgd/", "text" => "SGD", "class" => false),
    array("href" => "/sgd/centers/list/" . lpk(), "text" => "Centros de gestión", "class" => false),
    array("href" => "/sgd/centers/view/{$oid}", "text" => $center["name"], "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>