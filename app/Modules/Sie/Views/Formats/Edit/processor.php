<?php
require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

//[Services]-----------------------------------------------------------------------------
$request = service('request');
$bootstrap = service('bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service("server");
//[services]------------------------------------------------------------------------------------------------------------
$mformats = model("App\Modules\Sie\Models\Sie_Formats");
//[Process]-----------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Formats."));
$d = array(
    "format" => $f->get_Value("format"),
    "type" => $f->get_Value("type"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "instructions" => $f->get_Value("instructions"),
    "created_by" => $f->get_Value("created_by"),
    "updated_by" => $f->get_Value("updated_by"),
    "deleted_by" => $f->get_Value("deleted_by"),
);
//[Elements]-----------------------------------------------------------------------------
$row = $mformats->find($d["format"]);
$l["back"] = $f->get_Value("back");
$l["edit"] = "/sie/formats/edit/{$d["format"]}";
$asuccess = "sie/formats-edit-success-message.mp3";
$anoexist = "sie/formats-edit-noexist-message.mp3";
//[build]---------------------------------------------------------------------------------------------------------------
if (is_array($row)) {
    $edit = $mformats->update($d['format'], $d);
    $file = $request->getFile($f->get_fieldId("file"));
    if ($file->isValid()) {
        //[Local]-------------------------------------------------------------------------------------------------------
        $path = "/storages/" . md5($server::get_FullName()) . "/sie/formats";
        $realpath = ROOTPATH . "public" . $path;
        $rname = $file->getRandomName();
        $file->move($realpath, $rname);
        $name = $file->getClientName();
        $type = $file->getClientMimeType();
        $uri = "{$path}/{$rname}";
        $d['file'] = $uri;
        //[Storage]-----------------------------------------------------------------------------------------------------
        $fullpath = "{$realpath}/{$rname}";
        $spath = substr("{$path}/{$rname}", 1);
        $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
        $bucket = $storage->bucket("cloud-engine");
        $bucket->upload(fopen($fullpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
        $mformats->update($d['format'], $d);
    }


    $c = $bootstrap->get_Card("success", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Formats.edit-success-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Formats.edit-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
} else {
    $create = $mformats->insert($d);
    //echo($mformats->getLastQuery()->getQuery());
    $c = $bootstrap->get_Card("warning", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Formats.edit-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Formats.edit-noexist-message"), $d['format']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $anoexist,
    ));
}
echo($c);
cache()->clean();
?>
