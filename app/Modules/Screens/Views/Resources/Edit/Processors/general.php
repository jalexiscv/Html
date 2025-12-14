<?php
//[vars]----------------------------------------------------------------------------------------------------------
//$resource: Es trasferida directamente
$continue = "/Screens/resources/list/{$resource["title"]}/";
$edit = "/Screens/resources/edit/{$resource["resource"]}/";
$asuccess = "Screens/resources-edit-success-message.mp3";
unset($resource['type']);
unset($resource['file']);
//[Update]--------------------------------------------------------------------------------------------------------------
$edit = $model->update($resource['resource'], $resource);

//[Build]---------------------------------------------------------------------------------------------------------------
$smarty = service("smarty");
$smarty->set_Mode("bs5x");
$smarty->assign("title", lang("Resources.edit-success-title"));
$smarty->assign("message", sprintf(lang("Resources.edit-success-message"), $resource['resource']));
//$smarty->assign("edit", $edit);
$smarty->assign("continue", $continue);
$smarty->assign("voice", $asuccess);
$c = $smarty->view('alerts/card/success.tpl');
echo($c);
?>