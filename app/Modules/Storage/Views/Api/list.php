<?php

if (!empty($object)) {
    $attachments = model("App\Modules\Storage\Models\Storage_Attachments");
    $files = $attachments->get_FileListForObject($object);
    $response = [
        'object' => $object,
        'status' => 201,
        'error' => "Objeto consultado!",
        'messages' => [
            'files' => $files,
            'success' => 'File no stored!'
        ]
    ];
} else {
    $response = [
        'status' => 201,
        'error' => "No se definio el objeto!",
        'messages' => [
            'success' => 'File no stored!'
        ]
    ];
}
echo(json_encode($response));
?>