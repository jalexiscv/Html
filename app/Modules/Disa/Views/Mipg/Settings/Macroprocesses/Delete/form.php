<?php

$f = service("forms", array("lang" => "Nexus."));
$model = model("App\Modules\Disa\Models\Disa_Macroprocesses");
$processes = model("App\Modules\Disa\Models\Disa_Processes");
$linkeds = $processes->where("macroprocess", $oid)->find();
$r = $model->find($oid);

if (is_array($linkeds) && count($linkeds) > 0) {
    $name = urldecode($r["name"]);
    $message = "Este macroproceso no puede ser eliminado por tener procesos vinculados. presioné continuar para retornar al listado de macroprocesos.";
    $cancel = "/disa/settings/macroprocesses/list/" . lpk();
    $f->add_HiddenField("pkey", $oid);
    $f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $cancel, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
    $f->groups["gy"] = $f->get_GroupSeparator();
    $f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["cancel"]));
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("header", sprintf(lang("Disa.macroprocesses-delete-title"), $name));
    $smarty->assign("message", $message);
    $smarty->assign("form", $f);
    $smarty->assign("continue", null);
    $smarty->assign("voice", "disa/macroprocesses-indelible-message.mp3");
    echo($smarty->view('components/cards/indelible.tpl'));
} else {
    $name = urldecode($r["name"]);
    $message = sprintf(lang("Disa.macroprocesses-delete-message"), $name);
    $cancel = "/disa/settings/macroprocesses/list/" . lpk();
    $f->add_HiddenField("pkey", $oid);
    $f->fields["cancel"] = $f->get_Cancel("cancel", array("href" => $cancel, "text" => lang("App.Cancel"), "type" => "secondary", "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-right"));
    $f->fields["submit"] = $f->get_Submit("submit", array("value" => lang("App.Delete"), "proportion" => "col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 padding-left"));
    $f->groups["gy"] = $f->get_GroupSeparator();
    $f->groups["gz"] = $f->get_Buttons(array("fields" => $f->fields["submit"] . $f->fields["cancel"]));
    $smarty = service("smarty");
    $smarty->set_Mode("bs5x");
    $smarty->assign("header", sprintf(lang("Disa.macroprocesses-delete-title"), $name));
    $smarty->assign("message", $message);
    $smarty->assign("form", $f);
    $smarty->assign("continue", null);
    $smarty->assign("voice", "disa/macroprocesses-delete-message.mp3");
    echo($smarty->view('components/cards/delete.tpl'));
}

?>