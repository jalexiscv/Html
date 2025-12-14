<?php

function generate_wallet_permissions()
{
    $model = model("App\Modules\Security\Models\Security_Permissions", true);
    $permissions = array(
        "wallet-access",
        "wallet-currencies-create",
        "wallet-currencies-view",
        "wallet-currencies-view-all",
        "wallet-currencies-delete",
        "wallet-currencies-delete-all",
        "wallet-currencies-edit",
        "wallet-currencies-edit-all",
        "wallet-transactions-create",
        "wallet-transactions-view",
        "wallet-transactions-view-all",
        "wallet-transactions-delete",
        "wallet-transactions-delete-all",
        "wallet-transactions-edit",
        "wallet-transactions-edit-all",
    );
    generate_permissions($permissions, "WALLET");
}

function get_wallet_sidebar($active_url = false)
{
    $options = array(
        "home" => array("text" => lang("App.Home"), "href" => "/wallet", "icon" => "far fa-home"),
        "transactions" => array("text" => lang("App.Transactions"), "href" => "/wallet/transactions/list/" . lpk(), "icon" => "fas fa-exchange-alt", "permission" => "WALLET-ACCESS"),
        //"currencies" => array("text" => lang("App.Currencies"), "href" => "/wallet/currencies/list", "icon" => "far fa-badge-dollar", "permission" => "WALLET-ACCESS"),
    );
    $return = get_application_custom_sidebar($options, $active_url);
    return ($return);
}

?>