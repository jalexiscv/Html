<?php
$s = service('strings');
$row = $model->find($oid);
$type = $s->get_Strtolower($row["type"]);
$back = "/c4isr/cases/home/{$type}/" . lpk();
$data = $parent->get_Array();
$fgeneral = view('App\Modules\C4isr\Views\Cases\View\Forms\Cveweb\general', $data);
$fexpert = view('App\Modules\C4isr\Views\Cases\View\Forms\Cveweb\expert', $data);

$tabs = array(
    array("id" => "content", "text" => "General", "content" => $fgeneral, "active" => true),
    array("id" => "attachments", "text" => "Experto", "content" => $fexpert, "active" => false),
);

$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("tabs", $tabs);
$tab = $smarty->view('components/tabs/index.tpl');


//[Build]-----------------------------------------------------------------------------s
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->caching = 0;
$smarty->assign("type", "normal");
$smarty->assign("header", "CVE/{$oid}");
$smarty->assign("header_back", $back);
$smarty->assign("body", $tab);
$smarty->assign("footer", null);
$smarty->assign("file", __FILE__);
echo($smarty->view('components/cards/index.tpl'));

//+[Logger]------------------------------------------------------------------------------------------------------------
history_logger(array(
    "module" => "C4ISR",
    "type" => "ACCESS",
    "reference" => "COMPONENT",
    "object" => "CVEWEB",
    "log" => "El usuario accede a la vista del caso <a href=\"/c4isr/cases/view/{$oid}\" target=\"_blank\">{$oid}</a> del componete <a href=\"/c4isr/cases/home/cveweb/{$oid}\" target=\"_blank\">CVEWEB</a> del Módulo C4ISR",
));

?>