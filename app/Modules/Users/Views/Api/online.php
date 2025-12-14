<?php

$request = service('request');
$authentication = service('authentication');
$strings = service('strings');

if ($authentication->get_LoggedIn()) {
    $muf = model("App\Modules\Messenger\Models\Messenger_Users_Fields");
    $msa = model("App\Modules\Storage\Models\Storage_Attachments");
    $mstatuses = model("App\Modules\Users\Models\Users_Statuses");
    $statuses = $mstatuses->where('value', 'online')->findAll();
    $users = [];
    if (is_array($statuses)) {
        for ($i = 0; $i < count($statuses); $i++) {
            $user = $statuses[$i]['status'];
            $heartbeat = $statuses[$i]['heartbeat']; // Obtén el valor de heartbeat
            $heartbeatTimestamp = strtotime($heartbeat);// Convierte el valor de heartbeat en un timestamp de Unix
            $currentTimestamp = time();// Obtén el timestamp actual
            if ($currentTimestamp - $heartbeatTimestamp < 120) {
                if ($user != safe_get_user()) {
                    $statuses[$i]['user'] = $user;
                    $profile = $muf->get_Profile($user);
                    $statuses[$i]['name'] = $strings->get_Wrap($profile['name'], 24);
                    $statuses[$i]['alias'] = $profile['alias'];
                    $statuses[$i]['avatar'] = $profile['avatar'];
                    $users[] = $statuses[$i];
                }
            }
        }
        echo json_encode($users);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se encontraron usuarios en línea']);
    }
} else {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['status' => 'unauthorized', 'message' => 'Usuario sin iniciar sesión']);
}