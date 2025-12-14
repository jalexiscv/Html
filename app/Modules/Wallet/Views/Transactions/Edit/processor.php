<?php
$Authentication = new App\Libraries\Authentication();
$dates = new App\Libraries\Dates();
$prefix = "Transactions.";
$f = service("forms", array("lang" => "{$prefix}"));
$model = model('App\Modules\Wallet\Models\Wallet_Transactions', true);
/** Fields **/
$d = array(
    "transaction" => $f->get_Value("transaction"),
    "module" => $f->get_Value("module"),
    "user" => $f->get_Value("user"),
    "reference" => $f->get_Value("reference"),
    "currency" => $f->get_Value("currency"),
    "debit" => $f->get_Value("debit"),
    "credit" => $f->get_Value("credit"),
    "balance" => $f->get_Value("balance"),
    "status" => $f->get_Value("status"),
    "author" => $f->get_Value("author"),
);
$row = $model->where("transaction", $d["transaction"])->first();
/** Links **/
$link['continue'] = safe_strtolower("/{$module}/{$component}/list/");
if (isset($row["transaction"])) {
    $update = $model->update($row["transaction"], $d);
    $success = service("smarty");
    $success->assign("title", lang("{$prefix}update-success-title"));
    $success->assign("message", sprintf(lang("{$prefix}update-success-content"), $d["name"]));
    $success->assign("continue", $link['continue']);
    //$success->assign("voice","Transactions.update-success-voice");
    echo($success->view('alerts/success.tpl'));
} else {
    $danger = service("smarty");
    $danger->assign("title", lang("{$prefix}update-noexist-title"));
    $danger->assign("message", sprintf(lang("{$prefix}update-noexist-content"), $d["name"]));
    $danger->assign("permissions", strtoupper($singular));
    $danger->assign("continue", $link['continue']);
    //$danger->assign("voice","Transactions.update-noexist-voice");
    echo($danger->view('alerts/danger.tpl'));
}
?>
