<?php
$apikey = "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";

$PROMPT[0] = "Eres Javier, una inteligencia artificial entrenada en periodismo objetivo para interactuar con Bugavision. Siga cuidadosamente las instrucciones del usuario. Responde usando Markdown.";
$PROMPT[1] = "Quiero que respondas todo en idioma español";
$PROMPT[4] = "response y escribe con fluidez, sin dar mayores explicaciones";

// Verifica si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del mensaje enviado desde la solicitud
    $postData = file_get_contents('php://input');
    $jsonData = json_decode($postData, true);

    // Verifica si se pudo decodificar el JSON correctamente
    if ($jsonData !== null) {
        // Procesa el mensaje y prepara una respuesta
        $userMessage = $jsonData['message'];


        $msg = $userMessage;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apikey,
        ]);
        $PROMPTS = implode(", ", $PROMPT);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n     
                \"model\": \"gpt-3.5-turbo\",\n   
                \"messages\": [
                    {\"role\": \"user\", \"content\": \"{$msg}\"},
                    {\"role\": \"system\", \"content\": \"{$PROMPTS}\"}
                ],\n     
                \"temperature\": 0.2\n   }");

        $response = json_decode(curl_exec($ch));

        curl_close($ch);

        $responseMessage = $response->choices[0]->message->content;


        //$responseMessage = '¡Hola! Has dicho: ' . $userMessage;

        // Crea un arreglo con la respuesta
        $response = array('message' => $responseMessage);

        // Establece la cabecera de respuesta como JSON
        header('Content-Type: application/json');

        // Envía la respuesta como JSON
        echo json_encode($response);
    } else {
        // Si no se pudo decodificar el JSON, devuelve un mensaje de error
        echo 'Error al procesar el mensaje.';
    }
} else {
    // Si no se recibió una solicitud POST, devuelve un mensaje de error
    echo 'Acceso no permitido.';
}
?>

