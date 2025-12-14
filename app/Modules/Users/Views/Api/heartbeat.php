<?php

$request = service('request');
$authentication = service('authentication');

if ($authentication->get_LoggedIn()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $mstatuses = model("App\Modules\Users\Models\Users_Statuses");
        $date = new DateTime();
        $d = array(
            "status" => safe_get_user(),
            "heartbeat" => $date->format('Y-m-d H:i:s'),
            "value" => "online",
            "author" => safe_get_user(),
        );
        $create = $mstatuses->upsert($d);


        echo json_encode([
            'status' => 'success',
            'message' => 'Heartbeat received',
            'heartbeat' => $data['heartbeat'],
            'user' => safe_get_user()
        ]);
    } else {
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode(['status' => 'error', 'message' => 'Only POST method is allowed']);
    }
} else {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['status' => 'unauthorized', 'message' => 'Usuario sin iniciar sesión']);
}

// Asegúrate de que la configuración de tu servidor permita la recepción de solicitudes POST y la lectura del payload JSON