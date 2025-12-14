<?php

$strings = service("strings");
// Configuración inicial para la API de Moodle
$token = 'a99cf98a32a7bc899e0e9c45e4f50b8f'; // Deberías gestionar esto de forma más segura
$domainName = service("moodle")::getDomainName();
$functionName = 'core_user_create_users';
$restformat = 'json';

$courseCreated = false;
$errorInfo = null;
$createdCourseId = null;

$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');


$registrations = $mregistrations->limit(300)->find();

foreach ($registrations as $registration) {
    $newUser = [
        'username' => $registration["identification_number"],
        'password' => "94478998",
        'firstname' => $registration["first_name"] . " " . $registration["second_name"],
        'lastname' => $registration["first_surname"] . " " . $registration["second_surname"],
        'email' => $registration["email_address"],
    ];
    $params = [
        'wstoken' => $token,
        'wsfunction' => $functionName,
        'moodlewsrestformat' => $restformat,
        'users' => [$newUser]
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $domainName . '/webservice/rest/server.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($params),
    ]);

// Ejecutar y procesar la respuesta
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        echo 'Error cURL: ' . curl_error($curl);
    } else {
        $result = json_decode($response, true);
        if (isset($result['exception'])) {
            // Hubo un error en Moodle
            $urlmail = safe_urlencode(@$newUser['email']);
            $username = safe_urlencode($newUser['username']);
            echo "<br>-CEDULA: " . @$username . " Nombre:" . $newUser['firstname'] . " " . $newUser['lastname'] . " - " . $urlmail . "-Moodle Exception: {$result['exception']} – {$result['message']}";
            print_r($result);
        } else {
            // Éxito: devuelve array con id del usuario creado
            echo "<br>UsuarioID: " . $result[0]['id'] . " - Nombre: " . $newUser['firstname'] . " " . $newUser['lastname'];
        }
    }
    curl_close($curl);
}


/**
 * // Datos del nuevo usuario
 * $newUser = [
 * 'username'  => 'nuevo_usuario',
 * 'password'  => 'Password123!',
 * 'firstname' => 'Juan',
 * 'lastname'  => 'Pérez',
 * 'email'     => 'juan.perez@ejemplo.com',
 * ];
 *
 * $params = [
 * 'wstoken'            => $token,
 * 'wsfunction'         => $functionName,
 * 'moodlewsrestformat' => $restformat,
 * 'users'              => [$newUser]
 * ];
 *
 * // Preparar la petición cURL
 * $curl = curl_init();
 * curl_setopt_array($curl, [
 * CURLOPT_URL            => $domainName . '/webservice/rest/server.php',
 * CURLOPT_RETURNTRANSFER => true,
 * CURLOPT_POST           => true,
 * CURLOPT_POSTFIELDS     => http_build_query($params),
 * ]);
 *
 * // Ejecutar y procesar la respuesta
 * $response = curl_exec($curl);
 * if (curl_errno($curl)) {
 * echo 'Error cURL: ' . curl_error($curl);
 * } else {
 * $result = json_decode($response, true);
 * if (isset($result['exception'])) {
 * // Hubo un error en Moodle
 * echo "Moodle Exception: {$result['exception']} – {$result['message']}";
 * } else {
 * // Éxito: devuelve array con id del usuario creado
 * echo "Usuario creado con ID: " . $result[0]['id'];
 * }
 * }
 * curl_close($curl);
 **/

?>