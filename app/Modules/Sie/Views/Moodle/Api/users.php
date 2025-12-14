<?php

$mregistrations = model("App\Modules\Sie\Models\Sie_Registrations");
$registration = $_GET["registration"];
$registration = $mregistrations->getRegistration($registration);

$token = service("moodle")::getToken();
$domain = service("moodle")::getDomainName();
$function = 'core_user_create_users';
$endpoint = "$domain/webservice/rest/server.php";

$email = (!empty($registration["email_institutional"])) ? $registration["email_institutional"] : "e{$registration["registration"]}@utede.edu.co";

$nuevoUsuario = [
    'username' => $registration["identification_number"],
    'password' => $registration["identification_number"],
    'firstname' => $registration["first_name"] . " " . $registration["second_name"],
    'lastname' => $registration["first_surname"] . " " . $registration["second_surname"],
    'email' => $email,
    'auth' => "manual",
    'lang' => "es",
    'city' => "Buga",
    'country' => "Colombia",
    'idnumber' => $registration["identification_number"]
];

$params = http_build_query(['users' => [$nuevoUsuario]]);
$url = $endpoint . '?wstoken=' . $token . '&wsfunction=' . $function . '&moodlewsrestformat=json';
$curl = curl_init($url);
curl_setopt_array($curl, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => $params,
]);

$errorInfo = "";
$createdUserId = "";

$response = curl_exec($curl);
if ($response === false) {
    $errorInfo = 'Error cURL: ' . curl_error($curl);
}
curl_close($curl);

$result = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    $errorInfo = "Respuesta no es JSON válido: $response";
} elseif (isset($result[0]['id'])) {
    $createdUserId = $result[0]['id'];
} elseif (isset($result['exception'])) {
    $errorInfo = $result['message'] ?? 'Error desconocido al crear el usuario.';
}

$response = array(
    "createdUserId" => $createdUserId,
    "error" => $errorInfo
);

echo(json_encode($response));
?>