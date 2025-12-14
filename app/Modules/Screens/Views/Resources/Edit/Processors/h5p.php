<?php
//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service('Server');
//[vars]----------------------------------------------------------------------------------------------------------------
//$resource: Es trasferida directamente
$f = service("forms", array("lang" => "Resources."));
$continue = "/Screens/resources/list/{$resource["title"]}/";
$edit = "/Screens/resources/edit/{$resource["resource"]}/";
$asuccess = "Screens/resources-edit-success-message.mp3";
$file = $request->getFile($f->get_fieldId("file"));
unset($resource['type']);
unset($resource['file']);
//[Processor]-----------------------------------------------------------------------------------------------------------
$path = "/storages/" . md5($server::get_FullName()) . "/Screens/{$resource['resource']}";
$realpath = ROOTPATH . "public" . $path;
if (!file_exists($realpath)) {
    mkdir($realpath, 0777, true);
}
$rname = $file->getRandomName();
$file->move($realpath, $rname);
$name = $file->getClientName();
$type = $file->getClientMimeType();
//[Unzip]---------------------------------------------------------------------------------------------------------------
$zip = new ZipArchive();
$zip->open($realpath . "/" . $rname);
$zip->extractTo($realpath);
$zip->close();
$resource['url'] = "{$path}/index.html";
//[Asign]--------------------------------------------------------------------------------------------------------------
$resource['type'] = $type;
$resource['file'] = "{$path}/{$rname}";
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