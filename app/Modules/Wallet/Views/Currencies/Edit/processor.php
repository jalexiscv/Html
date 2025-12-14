<?php
$Authentication = new App\Libraries\Authentication();
$dates = new App\Libraries\Dates();
$prefix = "Wallet.Currencies-";
$f = service("forms", array("lang" => "{$prefix}"));
$model = model('App\Modules\Wallet\Models\Wallet_Currencies', true);
/** Fields **/
$d = array(
    "currency" => $f->get_Value("currency"),
    "name" => $f->get_Value("name", "", true),
    "abbreviation" => $f->get_Value("abbreviation"),
    "icon" => $f->get_Value("icon"),
    "author" => $f->get_Value("author"),
);
$row = $model->where("currency", $d["currency"])->first();
/** Links **/
$link['continue'] = safe_strtolower("/{$module}/{$component}/list?time=" . time());
if (isset($row["currency"])) {
    $update = $model->update($row["currency"], $d);
    $success = service("smarty");
    $success->assign("title", lang("{$prefix}update-success-title"));
    $success->assign("message", sprintf(lang("{$prefix}update-success-content"), $d["name"]));
    $success->assign("continue", $link['continue']);
    $success->assign("voice", "wallet-currencies-update-success-voice.mp3");
    echo($success->view('alerts/success.tpl'));
} else {
    $danger = service("smarty");
    $danger->assign("title", lang("{$prefix}update-noexist-title"));
    $danger->assign("message", sprintf(lang("{$prefix}update-noexist-content"), $d["name"]));
    $danger->assign("permissions", strtoupper($singular));
    $danger->assign("continue", $link['continue']);
    //$danger->assign("voice","Wallet.Currencies-update-noexist-voice");
    echo($danger->view('alerts/danger.tpl'));
}
?>
