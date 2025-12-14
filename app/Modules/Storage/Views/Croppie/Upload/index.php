<?php
require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

$authentication = service('authentication');
$request = service('request');
$dates = service('dates');
$server = service("server");

$file = $request->getFile("attachment");
//print_r($file);
if ($file->isValid()) {
    $path = "/storages/" . md5($server::get_FullName()) . "/images/croppie/{$oid}";
    $realpath = ROOTPATH . "public" . $path;
    if (!file_exists($realpath)) {
        mkdir($realpath, 0777, true);
    }
    $rname = $file->getRandomName();
    $file->move($realpath, $rname);
    $name = $file->getClientName();
    $type = $file->getClientMimeType();
    $src = "{$path}/{$rname}";
    //[Storage]-----------------------------------------------------------------------------------------------------
    $fullpath = "{$realpath}/{$rname}";
    $spath = substr("{$path}/{$rname}", 1);
    $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
    $bucket = $storage->bucket("cloud-engine");
    $bucket->upload(fopen($fullpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
}
/** Almacenar en la base de datos * */
$oid = $oid; // Objeto al cual se vinculara el archivo cargado
$reference = $request->getVar("reference"); // Referencia del objeto o su función
$d = array(
    "attachment" => pk(),
    "object" => $oid,
    "file" => $src,
    "type" => $type,
    "date" => $dates->get_Date(),
    "time" => $dates->get_Time(),
    "alt" => "",
    "title" => "",
    "size" => $file->getSize(),
    "reference" => $reference,
    "author" => $authentication->get_User(),
);
$ma = model('App\Modules\Storage\Models\Storage_Attachments', true);
$create = $ma->insert($d);

$musers = model("App\Modules\Security\Models\Security_Users");
$user = $musers->where("user", $oid)->first();
if (is_array($user)) {
    $mfields = model("App\Modules\Security\Models\Security_Users_Fields");
    $cache_profile = $mfields->get_CacheKey("profile-{$oid}");
    cache()->clean();
}

?>