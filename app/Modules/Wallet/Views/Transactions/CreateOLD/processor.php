<?php

$Authentication = new App\Libraries\Authentication();
$dates = new App\Libraries\Dates();
$prefix = "Wallet.Transactions";
$f = service("forms", array("lang" => "{$prefix}-"));
$mtransactions = model('App\Modules\Wallet\Models\Wallet_Transactions', true);


$user = $f->get_Value("user");
$debit = $f->get_Value("debit");
$credit = $f->get_Value("credit");
/** Fields * */
$d = array(
    "transaction" => $f->get_Value("transaction"),
    "module" => $f->get_Value("module"),
    "user" => $user,
    "reference" => $f->get_Value("reference"),
    "currency" => $f->get_Value("currency"),
    "debit" => $debit,
    "credit" => $credit,
    "balance" => $mtransactions->get_Balance($user) + $debit - $credit,
    "status" => $f->get_Value("status"),
    "author" => $f->get_Value("author"),
);
$row = $mtransactions->where("transaction", $d["transaction"])->first();
/** Links * */
$link["continue"] = safe_strtolower("/{$module}/{$component}/list/");
$link["duplicate"] = safe_strtolower("/{$module}/{$component}/view/{$d["transaction"]}");
/** Messages * */
if (isset($row["transaction"])) {
    $c = view("Alerts/warning", array(
        "title" => lang("{$prefix}-create-duplicate-title"),
        "content" => sprintf(lang("{$prefix}-create-duplicate-content"), $d["user"]),
        "buttons" => array(
            array("href" => $link["duplicate"], "text" => lang("App.View")),
            array("href" => $link["continue"], "text" => lang("App.Continue"))
        )
    ));
} else {
    $create = $mtransactions->insert($d);
    $c = view("Alerts/success", array(
        "title" => lang("{$prefix}-create-success-title"),
        "content" => sprintf(lang("{$prefix}-create-success-content"), $d["user"]),
        "buttons" => array(
            array("href" => $link["continue"], "text" => lang("App.Continue"))
        )
    ));
}
echo($c);
?>
