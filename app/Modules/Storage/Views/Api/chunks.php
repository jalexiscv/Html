<?php
require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

$authentication = service('authentication');
$request = service('request');
$dates = service('dates');
$server = service('server');
$ma = model('App\Modules\Storage\Models\Storage_Attachments', true);

//$file = $request->getFile("attachment");
//$name = $request->getVar("name");
//$size = $request->getVar("size");
//$module = $request->getVar("module");
//$object = $request->getVar("object");
//$reference = $request->getVar("reference");

$path = "/storages/" . md5($server::get_FullName()) . "/chunks/{$oid}";
$realpath = ROOTPATH . "public" . $path;
if (!file_exists($realpath)) {
    mkdir($realpath, 0777, true);
}

if (empty($_FILES) || $_FILES['file']['error']) {
    die('{"OK": 0, "info": "Failed to move uploaded file."}');
}
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
$name = $request->getVar("name");
$ext = substr($name, strrpos($name, '.') + 1);
$rname = md5($name) . "." . strtolower($ext);
$filePath = "{$realpath}/{$rname}";
// Open temp file
$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
if ($out) {
    $in = @fopen($_FILES['file']['tmp_name'], "rb");
    if ($in) {
        while ($buff = fread($in, 4096))
            fwrite($out, $buff);
    } else
        die('{"OK": 0, "info": "Failed to open input stream."}');
    @fclose($in);
    @fclose($out);
    @unlink($_FILES['file']['tmp_name']);
} else {
    die('{"OK": 0, "info": "Failed to open output stream."}');
}
if (!$chunks || $chunk == $chunks - 1) {
    rename("{$filePath}.part", $filePath);
    //[Storage]---------------------------------------------------------------------------------------------------------
    $fullpath = "{$realpath}/{$rname}";
    $spath = substr("{$path}/{$rname}", 1);
    $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
    $bucket = $storage->bucket("cloud-engine");
    $bucket->upload(fopen($fullpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
    //[Datos]-----------------------------------------------------------------------------------------------------------
    $d = array(
        "attachment" => pk(),
        "object" => $oid,
        "file" => "{$path}/{$rname}",
        "type" => finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filePath),
        "date" => $dates->get_Date(),
        "time" => $dates->get_Time(),
        "alt" => "",
        "title" => "",
        "size" => filesize($filePath),
        "reference" => "",
        "author" => $authentication->get_User(),
    );
    $create = $ma->insert($d);
    unlink($filePath);
}
die('{"OK": 1, "info": "Upload successful."}');
?>