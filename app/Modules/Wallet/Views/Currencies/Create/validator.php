<?php
$prefix = "Wallet.Currencies";
$f = service("forms", array("lang" => "{$prefix}-"));
/** Request **/
$f->set_ValidationRule("currency", "trim|required");
$f->set_ValidationRule("name", "trim|required");
$f->set_ValidationRule("abbreviation", "trim|required");
//$f->set_ValidationRule("icon","trim|required");
//$f->set_ValidationRule("author","trim|required");
//$f->set_ValidationRule("created_at","trim|required");
//$f->set_ValidationRule("updated_at","trim|required");
//$f->set_ValidationRule("deleted_at","trim|required");
/** Validation **/
$d["module"] = $module;
$d["component"] = $component;
if ($f->run_Validation()) {
    $c = view($namespaced . '\processor', $d);
} else {
    $alert = service("smarty");
    $alert->assign("title", lang("{$prefix}-validation-title"));
    $alert->assign("message", lang("{$prefix}-validation-message"));
    $alert->assign("errors", $f->validation->listErrors());
    $c = $alert->view('alerts/danger.tpl');
    $c .= view($namespaced . '\form', $d);
}
echo($c);
?>
