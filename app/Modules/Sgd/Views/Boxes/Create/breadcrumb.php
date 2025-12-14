<?php
/** @var string $oid */
$mboxes = model('App\Modules\Sgd\Models\Sgd_Boxes');
$mshelves = model('App\Modules\Sgd\Models\Sgd_Shelves');
$mcenters= model('App\Modules\Sgd\Models\Sgd_Centers');

$shelve= $mshelves->getShelve($oid);
$center= $mcenters->getCenter($shelve["center"]);

$bootstrap = service("bootstrap");
$menu = array(
    array("href" => "/sgd/", "text" => "SGD", "class" => false),
    array("href" => "/sgd/centers/list/" . lpk(), "text" => "Centros de gestión", "class" => false),
    array("href" => "/sgd/centers/view/{$center["center"]}", "text" => "{$center["name"]}", "class" => "active"),
    array("href" => "/sgd/shelves/view/{$shelve["shelve"]}", "text" => "{$shelve["name"]}", "class" => "active"),
);
echo($bootstrap->get_Breadcrumb($menu));
?>