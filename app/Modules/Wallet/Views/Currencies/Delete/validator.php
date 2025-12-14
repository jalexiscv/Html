<?php
$prefix = "Wallet.Currencies-validation-";
$f = service("forms", array("lang" => "{$prefix}"));
/** Request **/
$f->set_ValidationRule("value", "trim|required");
/** Validation **/
$d["module"] = $module;
$d["component"] = $component;
if ($f->run_Validation()) {
    $c = view($namespaced . '\processor', $d);
} else {
    $alert = service("smarty");
    $alert->assign("title", lang("{$prefix}title"));
    $alert->assign("message", lang("{$prefix}message"));
    $alert->assign("errors", $f->validation->listErrors());
    $c = $alert->view('alerts/danger.tpl');
    $c .= view($namespaced . '\form', $d);
}
echo($c);
?>
