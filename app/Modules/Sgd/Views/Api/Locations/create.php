<?php

$mlocations = model('App\Modules\Sgd\Models\Sgd_Locations');

// Obtener el cuerpo JSON de la petición
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

// Verificar si los datos son válidos
if (json_last_error() === JSON_ERROR_NONE && is_array($input)) {
    // Preparar los datos para guardar
    $data = [
        'location' => pk(),
        'registration' => $input['registration'] ?? null,
        'center' => $input['center'] ?? null,
        'shelve' => $input['shelve'] ?? null,
        'box' => $input['box'] ?? null,
        'folder' => $input['folder'] ?? null,
        'date' => date('Y-m-d'),
        'time' => date('H:i:s'),
        'author' => safe_get_user(),
    ];

    // Validar que los datos requeridos existan
    if (!empty($data['registration']) && !empty($data['center']) &&
        !empty($data['shelve']) && !empty($data['box']) && !empty($data['folder'])) {

        // Guardar en la base de datos
        $result = $mlocations->insert($data);


        if ($result) {
            // Éxito en la operación
            echo json_encode([
                    'status' => 'success',
                    'message' => 'Ubicación guardada correctamente',
                    'data' => [
                        'location' => $data['location'],
                        'registration' => $data['registration'],
                        'center' => $data['center'],
                        'shelve' => $data['shelve'],
                        'box' => $data['box'],
                        'folder' => $data['folder'],
                    ]
                ]
            );
        } else {
            // Error al guardar
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al guardar la ubicación',
                'errors' => $mlocations->errors(),
                'data'=>[
                    'location' => $data['location'],
                    'registration' => $data['registration'],
                    'center' => $data['center'],
                    'shelve' => $data['shelve'],
                    'box' => $data['box'],
                    'folder' => $data['folder'],
                    'date'=>$data['date'],
                    'time'=>$data['time'],
                    'author'=>$data['author'],
                ]
            ]);
        }
    } else {
        // Faltan datos requeridos
        echo json_encode(['status' => 'error', 'message' => 'Faltan campos requeridos']);
    }
} else {
    // JSON inválido
    echo json_encode(['status' => 'error', 'message' => 'Formato JSON inválido']);
}

// Establecer el encabezado de respuesta
//header('Content-Type: application/json');
cache()->clean();

?>