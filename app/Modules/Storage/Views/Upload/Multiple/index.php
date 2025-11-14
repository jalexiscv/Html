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

// Array para almacenar resultados de todos los archivos
$uploadedFiles = array();
$errors = array();
$hasErrors = false;

// Detectar cuántos archivos se están enviando
$fileIndex = 0;
$maxFiles = 100; // Límite de seguridad

while ($fileIndex < $maxFiles) {
    $file = $request->getFile("attachment{$fileIndex}");

    // Si no existe el archivo, salir del bucle
    if (!$file || $file->getName() === '') {
        break;
    }

    // Procesar el archivo
    if ($file->isValid()) {
        try {
            $path = "/storages/" . md5($server::get_FullName()) . "/attachments/single/{$data['object']}";
            $rname = $file->getRandomName();
            $localpath = ROOTPATH . "public" . $path;
            $file->move($localpath, $rname);
            $name = $file->getClientName();
            $type = $file->getClientMimeType();
            $src = "{$path}/{$rname}";

            //[google-storage]------------------------------------------------------------------------------------------------------
            $fulllocalpath = "{$localpath}/{$rname}";
            $spath = substr("{$path}/{$rname}", 1);
            $storage = new StorageClient(['keyFilePath' => APPPATH . 'ThirdParty/Google/keys.json']);
            $bucket = $storage->bucket("cloud-engine");
            $bucket->upload(fopen($fulllocalpath, 'r'), ['name' => $spath, 'predefinedAcl' => 'publicRead']);

            // Crear registro en base de datos
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
                "original_name" => $name,
                "file_index" => $fileIndex
            );

            $ma = model('App\Modules\Storage\Models\Storage_Attachments', true);
            $create = $ma->insert($d);

            // Agregar a resultados exitosos
            $uploadedFiles[] = $d;

        } catch (Exception $e) {
            $hasErrors = true;
            $errors[] = array(
                "file_index" => $fileIndex,
                "original_name" => $file->getClientName(),
                "status" => "error",
                "message" => "Error al procesar el archivo: " . $e->getMessage()
            );
        }

    } else {
        // Archivo no válido - capturar error
        $hasErrors = true;
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

        $errors[] = array(
            "file_index" => $fileIndex,
            "original_name" => $file->getName(),
            "status" => "error",
            "message" => $errorMessage,
            "error_code" => $errorCode,
            "has_file" => $file->getName() !== '',
            "size" => $file->getSize(),
            "type" => $file->getClientMimeType()
        );
    }

    $fileIndex++;
}

// Actualizar el estado general basado en los resultados
if ($hasErrors && count($uploadedFiles) === 0) {
    $data['status'] = 'error';
} elseif ($hasErrors && count($uploadedFiles) > 0) {
    $data['status'] = 'partial';
}

// Preparar respuesta
$data['data'] = array(
    'uploaded_count' => count($uploadedFiles),
    'error_count' => count($errors),
    'total_processed' => $fileIndex,
    'uploaded_files' => $uploadedFiles,
    'errors' => $errors
);

//[db]------------------------------------------------------------------------------------------------------------------
//[/db]-----------------------------------------------------------------------------------------------------------------
echo(json_encode($data));
?>