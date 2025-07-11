<?php
$account = "10026255";
$apikey = "CCJx7MeEcgFtzGQosdfUqFOtwL6IlI";
$token = "d43ec5dee6d2a1f9c766163c0a714997";
$apiurl = "https://api103.hablame.co/api";

// URL del endpoint al que deseas enviar la solicitud POST
$url = $apiurl . "/sms/v3/send/marketing";

// Datos que se enviarán en el cuerpo de la solicitud
$data = array(
    "toNumber" => "573117977281",
    "sms" => "SMS ALEXIS",
    "flash" => "0",
    "sc" => "890202",
    "request_dlvr_rcpt" => "0"
);

// Convertir los datos a formato JSON
$jsonData = json_encode($data);

// Configurar las opciones de la solicitud
$options = array(
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => $jsonData,
    CURLOPT_HTTPHEADER => array(
        "Accept: application/json",
        "Account: " . $account,
        "ApiKey: " . $apikey,
        "Content-Type: application/json",
        "Token: " . $token
    )
);

// Inicializar cURL y establecer las opciones
$curl = curl_init();
curl_setopt_array($curl, $options);

// Realizar la solicitud y obtener la respuesta
$response = curl_exec($curl);

// Verificar si ocurrió algún error
if (curl_errno($curl)) {
    $error = curl_error($curl);
    // Manejar el error adecuadamente
} else {
    // Procesar la respuesta
    $responseData = json_decode($response, true);
    print_r($responseData);
    // Realizar las acciones necesarias con los datos de la respuesta
}

// Cerrar la conexión cURL
curl_close($curl);
?>