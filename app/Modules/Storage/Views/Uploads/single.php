<?php
require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use App\Libraries\Dates;
use Google\Cloud\Storage\StorageClient;

$Authentication = new App\Libraries\Authentication();
$request = service('request');
$dates = service('dates');
$server = service('server');
//[request]-------------------------------------------------------------------------------------------------------------
$file = $request->getFile("attachment");
$reference = $request->getVar("reference");
//[process]-------------------------------------------------------------------------------------------------------------
if ($file->isValid()) {
    $path = "/storages/" . md5($server::get_FullName()) . "/attachments/single/{$id}";
    $rname = $file->getRandomName();
    $localpath = ROOTPATH . "public" . $path;
    $file->move($localpath, $rname);
    $name = $file->getClientName();
    $type = $file->getClientMimeType();
    $src = "{$path}/{$rname}";
}
/** Almacenar en la base de datos * */
$oid = $id; // Objeto al cual se vinculara el archivo cargado
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
//[google-storage]---------------------------------------------------------------------------------------------------------
$fulllocalpath = "{$localpath}/{$rname}";
$spath = substr("{$path}/{$rname}", 1);
$storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
$bucket = $storage->bucket("cloud-engine");
$bucket->upload(fopen($fulllocalpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
//[Datos]-----------------------------------------------------------------------------------------------------------
$ma = model('App\Modules\Storage\Models\Storage_Attachments', true);
$create = $ma->insert($d);
echo(json_encode($d));
?>