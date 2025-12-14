<?php

use App\Libraries\Bootstrap;
use App\Libraries\Grid;


$authentication = service('authentication');
$grid = new Grid(array(
    "id" => "table-" . pk(),
    "side_pagination" => "client",
    "ajax" => "/application/modules/ajax/list/",
    "create" => "/application/modules/create/",
    "cols" => array(
        //"module"=>lang("App.module"),
        //"alias"=>lang("App.alias"),
        //"title"=>lang("App.title"),
        //"description"=>lang("App.description"),
        //"date"=>lang("App.date"),
        //"time"=>lang("App.time"),
        //"author"=>lang("App.author"),
        "options" => lang("App.Options")
    )
));
$b = new Bootstrap();
$card = $b->get_card("card-" . pk(), array(
    "title" => lang("Nexus.modules-list-title"),
    "content" => $grid
));
echo($card);
?>
