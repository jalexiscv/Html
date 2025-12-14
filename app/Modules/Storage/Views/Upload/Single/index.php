<?php

require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use App\Libraries\Dates;
use Google\Cloud\Storage\StorageClient;

//[services]------------------------------------------------------------------------------------------------------------
$authentication = service('authentication');
$request = service('request');
$dates = service('dates');
$server = service('server');
//[request]-------------------------------------------------------------------------------------------------------------
$reference = $request->getVar("reference") ?? null;
$data = array(
    'module' => $module,
    'object' => $object,
    'status' => 'success',
);

$d = array();
$file = $request->getFile("attachment0");
if ($file->isValid()) {
    $path = "/storages/" . md5($server::get_FullName()) . "/attachments/single/{$data['object']}";
    $rname = $file->getRandomName();
    $localpath = ROOTPATH . "public" . $path;
    $file->move($localpath, $rname);
    $name = $file->getClientName();
    $type = $file->getClientMimeType();
    $src = "{$path}/{$rname}";
    //[google-storage]---------------------------------------------------------------------------------------------------------
    $fulllocalpath = "{$localpath}/{$rname}";
    $spath = substr("{$path}/{$rname}", 1);
    $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
    $bucket = $storage->bucket("cloud-engine");
    $bucket->upload(fopen($fulllocalpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);
    $d = array(
        "attachment" => strtoupper(uniqid()),
        "module" => $data['module'],
        "object" => $data['object'],
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
    //$d["file"]=cdn_url($d["file"]);
}else{
    $errorCode = $file->getError();
    $errorMessage = '';
    switch ($errorCode) {
        case UPLOAD_ERR_INI_SIZE:
            $maxFileSize = ini_get('upload_max_filesize');
            $errorMessage = "El archivo excede el tamaño máximo permitido en php.ini ({$maxFileSize})";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $errorMessage = 'El archivo excede el tamaño máximo permitido en el formulario';
            break;
        case UPLOAD_ERR_PARTIAL:
            $errorMessage = 'El archivo se subió parcialmente';
            break;
        case UPLOAD_ERR_NO_FILE:
            $errorMessage = 'No se seleccionó ningún archivo';
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $errorMessage = 'No existe un directorio temporal';
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $errorMessage = 'Error al escribir el archivo en disco';
            break;
        case UPLOAD_ERR_EXTENSION:
            $errorMessage = 'Una extensión de PHP detuvo la carga';
            break;
        default:
            $errorMessage = 'Error desconocido: ' . $errorCode;
    }
    // También verifica la configuración del formulario
    $d = array(
        "status" => "error",
        "message" => $errorMessage,
        "error_code" => $errorCode,
        "has_file" => $file->getName() !== '',
        "name" => $file->getName(),
        "size" => $file->getSize(),
        "type" => $file->getClientMimeType()
    );
}
//[db]------------------------------------------------------------------------------------------------------------------
//[/db]-----------------------------------------------------------------------------------------------------------------
$data['data'] = $d;
echo(json_encode($data))
?>