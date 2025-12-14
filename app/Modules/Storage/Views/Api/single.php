<?php
require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use Google\Cloud\Storage\StorageClient;

$authentication = service('authentication');
$request = service('request');
$dates = service('dates');
$server = service('server');
$ma = model('App\Modules\Storage\Models\Storage_Attachments', true);

$file = $request->getFile("attachment");
$name = $request->getVar("name");
$size = $request->getVar("size");
$module = $request->getVar("module");
$object = $request->getVar("object");
$reference = $request->getVar("reference"); // Referencia del objeto o su función

if ($file->isValid()) {
    $path = "/storages/" . md5($server::get_FullName()) . "/images/{$object}";
    $realpath = ROOTPATH . "public" . $path;
    if (!file_exists($realpath)) {
        mkdir($realpath, 0777, true);
    }
    $rname = $file->getRandomName();
    $file->move($realpath, $rname);
    $name = $file->getClientName();
    $type = $file->getClientMimeType();
    $uri = "{$path}/{$rname}";
    //[Storage]---------------------------------------------------------------------------------------------------------
    $fullpath = "{$realpath}/{$rname}";
    $spath = substr("{$path}/{$rname}", 1);
    $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
    $bucket = $storage->bucket("cloud-engine");
    $bucket->upload(fopen($fullpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
    //[Datos]-----------------------------------------------------------------------------------------------------------
    $oid = $object;
    $d = array(
        "attachment" => pk(),
        "object" => $oid,
        "file" => $uri,
        "type" => $type,
        "date" => $dates->get_Date(),
        "time" => $dates->get_Time(),
        "alt" => "",
        "title" => "",
        "size" => $file->getSize(),
        "reference" => $reference,
        "author" => $authentication->get_User(),
    );

    $create = $ma->insert($d);
    //Respuesta
    $response = [
        'status' => 201,
        'error' => false,
        'messages' => [
            'success' => 'File stored!'
        ]
    ];
} else {
    //Respuesta
    $response = [
        'status' => 201,
        'error' => "Archivo invalido!",
        'messages' => [
            'success' => 'File no stored!'
        ]
    ];
}

echo(json_encode($response));
?>