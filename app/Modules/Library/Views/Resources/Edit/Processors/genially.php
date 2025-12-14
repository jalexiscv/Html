<?php
$bootstrap = service("bootstrap");
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
$continue = "/library/resources/list/{$resource["title"]}/";
$edit = "/library/resources/edit/{$resource["resource"]}/";
$asuccess = "library/resources-edit-success-message.mp3";
$file = $request->getFile($f->get_fieldId("file"));
unset($resource['type']);
unset($resource['file']);
//[Processor]-----------------------------------------------------------------------------------------------------------
$path = "/storages/" . md5($server::get_FullName()) . "/library/{$resource['resource']}";
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
$resource['url'] = "{$path}/genially.html";
//[Asign]--------------------------------------------------------------------------------------------------------------
$resource['type'] = $type;
$resource['file'] = "{$path}/{$rname}";
//[Update]--------------------------------------------------------------------------------------------------------------
$edit = $model->update($resource['resource'], $resource);

//[Build]---------------------------------------------------------------------------------------------------------------
$c = $bootstrap->get_Card("success", array(
    "class" => "card-success",
    "icon" => "fa-duotone fa-triangle-exclamation",
    "title" => lang("Resources.edit-success-title"),
    "text-class" => "text-center",
    "text" => lang("Resources.edit-success-message"),
    "footer-continue" => $continue,
    "footer-class" => "text-center",
    "voice" => $asuccess,
));
echo($c);
?>