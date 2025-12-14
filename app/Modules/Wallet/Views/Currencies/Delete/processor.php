<?php
$Authentication = new App\Libraries\Authentication();
$dates = new App\Libraries\Dates();
$prefix = "Wallet.Currencies-delete-";
$f = service("forms", array("lang" => "{$prefix}-"));
$model = model("App\Modules\Wallet\Models\Wallet_Currencies");
$value = $f->get_Value("value");
/** Fields * */
$delete = $model->delete($value);
$link['continue'] = safe_strtolower("/{$module}/{$component}/list/");
$success = service("smarty");
$success->assign("title", lang("{$prefix}success-title"));
$success->assign("message", sprintf(lang("{$prefix}success-content"), $d["name"]));
$success->assign("continue", $link['continue']);
//$success->assign("voice","Wallet.Currenciesdelete-success-voice");
echo($success->view('alerts/success.tpl'));
?>
