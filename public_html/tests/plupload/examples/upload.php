<?php

/*
// Establecer el directorio de destino para guardar el archivo
$targetDir = "uploads/";

// Obtener el nombre del archivo subido y concatenar el directorio de destino
$fileName = $targetDir . basename($_FILES["file"]["name"]);

// Mover el archivo temporal a la ubicación deseada en el servidor
if (move_uploaded_file($_FILES["file"]["tmp_name"], $fileName)) {
    // Si la transferencia es exitosa, imprimir un mensaje con el nombre del archivo
    echo "El archivo " . basename($_FILES["file"]["name"]) . " ha sido subido.";
} else {
    // Si hay un error, imprimir un mensaje de error
    echo "Ha ocurrido un error al subir el archivo.";
}
*/

if (empty($_FILES) || $_FILES['file']['error']) {
    die('{"OK": 0, "info": "Failed to move uploaded file."}');
}

$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
$filePath = "uploads/$fileName";


// Open temp file
$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
if ($out) {
    // Read binary input stream and append it to temp file
    $in = @fopen($_FILES['file']['tmp_name'], "rb");

    if ($in) {
        while ($buff = fread($in, 4096))
            fwrite($out, $buff);
    } else
        die('{"OK": 0, "info": "Failed to open input stream."}');

    @fclose($in);
    @fclose($out);

    @unlink($_FILES['file']['tmp_name']);
} else
    die('{"OK": 0, "info": "Failed to open output stream."}');


// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
    // Strip the temp .part suffix off
    rename("{$filePath}.part", $filePath);
}

die('{"OK": 1, "info": "Upload successful."}');
?>