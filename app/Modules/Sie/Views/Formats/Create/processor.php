<?php
require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

//[Services]-----------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('Dates');
$strings = service('strings');
$authentication = service('authentication');
$server = service("server");
//[Models]--------------------------------------------------------------------------------------------------------------
$f = service("forms", array("lang" => "Sie_Formats."));
$mformats = model("App\Modules\Sie\Models\Sie_Formats");
//[Vars]----------------------------------------------------------------------------------------------------------------
$d = array(
    "format" => $f->get_Value("format"),
    "type" => $f->get_Value("type"),
    "file" => $f->get_Value("file"),
    "name" => $f->get_Value("name"),
    "description" => $f->get_Value("description"),
    "instructions" => $f->get_Value("instructions"),
    "created_by" => $f->get_Value("created_by"),
    "updated_by" => $f->get_Value("updated_by"),
    "deleted_by" => $f->get_Value("deleted_by"),
);
$row = $mformats->find($d["format"]);
$l["back"] = $f->get_Value("back");
$l["edit"] = "/sie/formats/edit/{$d["format"]}";
$asuccess = "sie/formats-create-success-message.mp3";
$aexist = "sie/formats-create-exist-message.mp3";
if (is_array($row)) {
    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Sie_Formats.create-duplicate-title"),
        "text-class" => "text-center",
        "text" => lang("Sie_Formats.create-duplicate-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $aexist,
    ));
} else {
    $create = $mformats->insert($d);
    //echo($mformats->getLastQuery()->getQuery());

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
        "title" => lang("Sie_Formats.create-success-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Sie_Formats.create-success-message"), $d['format']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $asuccess,
    ));
}
echo($c);
cache()->clean();
?>
