<?php

/**********************
 *  Configuración básica
 **********************/
$token = 'ce890746630ebf2c6b7baf4dde8f41b4';
$domain = 'https://campus.utede.edu.co';
$function = 'core_user_create_users';
$endpoint = "$domain/webservice/rest/server.php";

// Recibir datos del JSON POST enviado por XHR
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Verificar que se recibieron los datos correctamente
if (!$data) {
    echo json_encode([
        'success' => false,
        'message' => 'No se recibieron datos válidos'
    ]);
    exit;
}

// Extraer los datos del JSON
$ruser = $data['user'] ?? '';
$citizenshipcard = $data['citizenshipcard'] ?? '';
$firstname = $data['firstname'] ?? '';
$lastname = $data['lastname'] ?? '';
$email = $data['email'] ?? '';
$registration = $data['registration'] ?? '';

// Limpiar y validar datos
$citizenshipcard = trim($citizenshipcard);
$firstname = trim($firstname);
$lastname = trim($lastname);
$email = trim(strtolower($email));
$ruser = trim($ruser);

// Remover caracteres especiales y acentos de nombres
$firstname = iconv('UTF-8', 'ASCII//TRANSLIT', $firstname);
$lastname = iconv('UTF-8', 'ASCII//TRANSLIT', $lastname);

// Validar campos obligatorios
if (empty($citizenshipcard) || empty($firstname) || empty($lastname)) {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan campos obligatorios: cédula, nombre o apellido'
    ]);
    exit;
}

// Validar email o generar uno por defecto
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email = "e{$ruser}@utede.edu.co";
}

// Validar que la cédula sea numérica
if (!is_numeric($citizenshipcard)) {
    echo json_encode([
        'success' => false,
        'message' => 'La cédula debe ser numérica'
    ]);
    exit;
}

$nuevoUsuario = [
    'username' => $citizenshipcard,
    'password' => $citizenshipcard,
    'firstname' => $firstname,
    'lastname' => $lastname,
    'email' => $email,
    'auth' => "manual",
    'lang' => "es",
    'city' => "Buga",
    'country' => "CO",
    'idnumber' => $ruser
];

// Construir parámetros correctamente para Moodle
$params = [
    'wstoken' => $token,
    'wsfunction' => $function,
    'moodlewsrestformat' => 'json',
    'users[0][username]' => $nuevoUsuario['username'],
    'users[0][password]' => $nuevoUsuario['password'],
    'users[0][firstname]' => $nuevoUsuario['firstname'],
    'users[0][lastname]' => $nuevoUsuario['lastname'],
    'users[0][email]' => $nuevoUsuario['email'],
    'users[0][auth]' => $nuevoUsuario['auth'],
    'users[0][lang]' => $nuevoUsuario['lang'],
    'users[0][city]' => $nuevoUsuario['city'],
    'users[0][country]' => $nuevoUsuario['country'],
    'users[0][idnumber]' => $nuevoUsuario['idnumber']
];

$curl = curl_init($endpoint);
curl_setopt_array($curl, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => http_build_query($params),
    CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => false
]);

$errorInfo = "";
$createdUserId = "";

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ($response === false) {
    $errorInfo = 'Error cURL: ' . curl_error($curl);
} elseif ($httpCode !== 200) {
    $errorInfo = "Error HTTP: $httpCode";
}
curl_close($curl);

if (empty($errorInfo)) {
    $result = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $errorInfo = "Respuesta no es JSON válido: $response";
    } elseif (isset($result[0]['id'])) {
        $createdUserId = $result[0]['id'];
    } elseif (isset($result['exception'])) {
        $errorInfo = $result['message'] ?? 'Error desconocido al crear el usuario.';
    } elseif (isset($result['errorcode'])) {
        $errorInfo = $result['message'] ?? $result['errorcode'];
    } else {
        $errorInfo = "Respuesta inesperada: " . json_encode($result);
    }
}

// Respuesta estructurada para el frontend
$response = array(
    "success" => !empty($createdUserId),
    "message" => !empty($createdUserId) ? "Usuario creado exitosamente" : $errorInfo,
    "data" => array(
        "createdUserId" => $createdUserId,
        "user" => $ruser,
        "citizenshipcard" => $citizenshipcard,
        "firstname" => $firstname,
        "lastname" => $lastname,
        "email" => $email
    )
);

echo(json_encode($response));
?>