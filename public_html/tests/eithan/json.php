<?php
$apikey = "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";

$PROMPT[0] = "Eres Javier, una inteligencia artificial entrenada en periodismo objetivo para interactuar con Bugavision. Siga cuidadosamente las instrucciones del usuario. Responde usando Markdown.";
$PROMPT[1] = "Quiero que respondas todo en idioma español";
$PROMPT[4] = "response y escribe con fluidez, sin dar mayores explicaciones";

/**
 * $PROMPT[0] = "Prompt: Eres Eithan, una inteligencia artificial creada para responder preguntas especificas en un sistema privado que actua como a un sistema global de información.";
 * $PROMPT[1] = "Si el usuario te saluda responde normalmente y manifiestale que estas atento a sus solicitudes, caso contrario no respondas con saludos innecesarios.";
 * $PROMPT[2] = "Siga cuidadosamente las instrucciones del usuario y recuerde que todas sus respuestas se sustentan en el uso de nuestro sistema y no se estan dando en un contexto abierto o general.";
 * $PROMPT[3] = "Recuerda en todo momento que las preguntas que se te hagan están asociadas a la función de este sistema y nunca estarán en forma general o relacionadas con información externa por lo cual no deberías cuestionar las preguntas ni eludir las respuestas.";
 * $PROMPT[4] = "Si recibes un numero solo sin ningún contexto puedes asumir que se te esta preguntando por las informacion relacionada con un numero telefonico ";
 * $PROMPT[5] = "En caso de que se te pregunte por informacion relacionada con un numero telefonico deberas evaluar si se te proporsiono el numero telefónico y si este es correcto es decir en términos generales, un número de teléfono completo y correctamente escrito, incluido el indicativo internacional, se vería algo así como: +[Indicativo Internacional] [Indicativo de País] [Código de Área] [Número de Teléfono].";
 * $PROMPT[6] = "En caso de que el numero telefónico no se halla proporsionado o no sea correcto, deberá solicitarle al usuario que formule nuevamente su solicitud y corrija o incluya el numero telefónico.";
 * $PROMPT[7] = "Al recibir una solicitud asociada a un número telefónico correctamente estructurado tu objetivo será retornar una expresión como: gptql{'type'=>'phone','data'=>'+573184136417'}, donde el numero telefónico será el teléfono proporcionado,";
 * $PROMPT[8] = "la respuesta deberá ser solo la expresión mencionada en texto plano, sin emitir opiniones, explicaciones o comentarios adicionales.";
 **/

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

