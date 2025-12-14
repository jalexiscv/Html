<?php

$mcenters = model('App\Modules\Sgd\Models\Sgd_Centers');
$mshelves = model('App\Modules\Sgd\Models\Sgd_Shelves');

$shelve= $mshelves->getShelve($oid);
$center= $mcenters->getCenter($shelve["center"]);

$b = service("bootstrap");
$menu = array(
    array("href" => "/sgd/", "text" => "SGD", "class" => false),
    array("href" => "/sgd/centers/list/" . lpk(), "text" => "Centros de gestión", "class" => false),
    array("href" => "/sgd/centers/view/{$center["center"]}", "text" => $center["name"], "class" => "active"),
);
echo($b->get_Breadcrumb($menu));
?>