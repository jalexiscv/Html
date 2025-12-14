<?php

use App\Libraries\Bootstrap;
use App\Libraries\Grid;


$authentication = service('authentication');
$grid = new Grid(array(
    "id" => "table-" . pk(),
    "side_pagination" => "server",
    "ajax" => "/wallet/transactions/ajax/list?time=" . time(),
    "create" => "/wallet/transactions/create?time=" . time(),
    "cols" => array(
        "transaction" => array("text" => lang("App.Transaction"), "align" => "center"),
        "module" => array("text" => lang("App.Module"), "align" => "center", "visible" => false),
        "user" => array("text" => lang("App.User"), "align" => "center"),
        "reference" => array("text" => lang("App.Reference"), "align" => "left"),
        //"currency"=>lang("App.currency"),
        "debit" => array("text" => lang("App.Debit"), "align" => "right"),
        "credit" => array("text" => lang("App.Credit"), "align" => "right"),
        "balance" => array("text" => lang("App.Balance"), "align" => "right"),
        //"status"=>lang("App.status"),
        //"author"=>lang("App.author"),
        //"created_at"=>lang("App.created_at"),
        //"updated_at"=>lang("App.updated_at"),
        //"deleted_at"=>lang("App.deleted_at"),
        "options" => lang("App.Options")
    )
));
$b = new Bootstrap();
$card = $b->get_card("card-" . pk(), array(
    "title" => lang("Transactions.list-title"),
    "content" => $grid
));
echo($card);
?>
