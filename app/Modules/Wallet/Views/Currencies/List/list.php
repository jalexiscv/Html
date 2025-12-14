<?php

use App\Libraries\Bootstrap;
use App\Libraries\Grid;


$authentication = service('authentication');
$grid = new Grid(array(
    "id" => "table-" . pk(),
    "side_pagination" => "client",
    "ajax" => "/wallet/currencies/ajax/list?time=" . time(),
    "create" => "/wallet/currencies/create?time=" . time(),
    "cols" => array(
        "currency" => array("text" => lang("Wallet.Currency-Code"), "visible" => false),
        "name" => lang("App.Name"),
        "abbreviation" => lang("App.Abbreviation"),
        //"icon"=>lang("App.icon"),
        //"author"=>lang("App.author"),
        //"created_at"=>lang("App.created_at"),
        //"updated_at"=>lang("App.updated_at"),
        //"deleted_at"=>lang("App.deleted_at"),
        "options" => lang("App.Options")
    )
));
$b = new Bootstrap();
$card = $b->get_card("card-" . pk(), array(
    "title" => lang("Wallet.Currencies-list-title"),
    "content" => $grid
));
echo($card);
?>
