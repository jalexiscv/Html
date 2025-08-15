<?php
/**
 * Clase Sms
 *
 * Esta clase proporciona métodos para enviar mensajes SMS utilizando la API de Háblame.co
 * Implementa funcionalidad completa para comunicarse con la API REST de Háblame
 *
 * @author Cascade
 * @version 1.0
 */

// Cargamos la configuración
require_once 'config.php';

class Sms
{
    /**
     * URL base de la API de Háblame
     * @var string
     */
    private $apiUrl;

    /**
     * Clave de API para autenticación
     * @var string
     */
    private $apiKey;

    /**
     * Número de remitente por defecto (opcional)
     * @var string|null
     */
    private $from = null;

    /**
     * Constructor de la clase
     *
     * @param string $apiKey Opcional - Clave de API para autenticación
     * @param string $from Opcional - Número remitente
     */
    public function __construct($apiKey = null, $from = null)
    {
        global $config;

        // Establecemos la URL de la API desde la configuración
        $this->apiUrl = $config['apiUrl'];

        // Establecemos la clave API, priorizando la pasada por parámetro
        if ($apiKey) {
            $this->apiKey = $apiKey;
        } else {
            $this->apiKey = $config['apiKey'];
        }

        // Establecemos el remitente, priorizando el pasado por parámetro
        if ($from) {
            $this->from = $from;
        } elseif (isset($config['from']) && $config['from']) {
            $this->from = $config['from'];
        }
    }

    /**
     * Envía un mensaje SMS a un número específico
     *
     * @param string $numero Número de teléfono destinatario (formato: 10 dígitos, sin prefijo país)
     * @param string $mensaje Contenido del mensaje (máximo 160 caracteres)
     * @param array $opciones Opciones adicionales para el envío:
     *                       - certificate: bool - Si el mensaje debe ser certificado
     *                       - flash: bool - Si el mensaje es tipo Flash
     *                       - sendDate: string - Fecha y hora de envío programado (formato ISO)
     *                       - campaignName: string - Nombre de la campaña
     * @return array Respuesta de la API
     * @throws Exception Si ocurre un error durante el envío
     */
    public function send($numero, $mensaje, $opciones = [])
    {
        // Preparamos los datos del mensaje
        $data = [
            'toNumber' => $this->formatearNumero($numero),
            'sms' => $mensaje,
            'X-Hablame-Key' => $this->apiKey
        ];

        // Agregamos opciones adicionales si están presentes
        if ($this->from) {
            $data['from'] = $this->from;
        }

        if (isset($opciones['certificate']) && $opciones['certificate']) {
            $data['certificate'] = true;
        }

        if (isset($opciones['flash']) && $opciones['flash']) {
            $data['flash'] = true;
        }

        if (isset($opciones['sendDate'])) {
            $data['sendDate'] = $opciones['sendDate'];
        }

        if (isset($opciones['campaignName'])) {
            $data['campaignName'] = $opciones['campaignName'];
        }

        // Realizamos la petición a la API
        $resultado = $this->realizarPeticion($data);

        // Validamos la respuesta
        return $this->procesarRespuesta($resultado);
    }

    /**
     * Formatea el número de teléfono para asegurarse que cumple con el formato requerido
     *
     * @param string $numero Número de teléfono
     * @return string Número formateado
     */
    private function formatearNumero($numero)
    {
        // Eliminamos cualquier caracter que no sea un dígito
        $numero = preg_replace('/[^0-9]/', '', $numero);

        // Para Colombia, aseguramos que tenga 10 dígitos (sin el código de país)
        if (strlen($numero) == 10) {
            // Está correcto, lo devolvemos tal cual
            return $numero;
        } elseif (strlen($numero) == 12 && substr($numero, 0, 2) == '57') {
            // Si tiene el formato 57XXXXXXXXXX, eliminamos el prefijo 57
            return substr($numero, 2);
        } elseif (strlen($numero) == 13 && substr($numero, 0, 3) == '057') {
            // Si tiene el formato 057XXXXXXXXXX, eliminamos el prefijo 057
            return substr($numero, 3);
        } elseif (strlen($numero) == 11 && $numero[0] == '0') {
            // Si tiene un 0 al inicio (formato de algunos países), lo eliminamos
            return substr($numero, 1);
        }

        // Si no cumple con ningún formato conocido, lo devolvemos tal cual
        return $numero;
    }

    /**
     * Realiza una petición HTTP a la API de Háblame
     *
     * @param array $data Datos a enviar en la petición
     * @return array|false Respuesta de la API o false en caso de error
     */
    private function realizarPeticion($data)
    {
        // Guardamos los datos que se envían para diagnóstico
        $datosEnviados = $data;

        // Convertimos los datos a formato JSON
        $jsonData = json_encode($data);

        // Registramos la petición para diagnóstico
        $logPeticion = "-------- PETICIÓN A API HÁBLAME --------\n";
        $logPeticion .= "URL: {$this->apiUrl}\n";
        $logPeticion .= "Datos enviados: " . json_encode($datosEnviados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
        $logPeticion .= "----------------------------------------\n";
        file_put_contents('api_debug.log', $logPeticion, FILE_APPEND);

        // Preparamos la petición cURL
        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData),
            'X-Hablame-Key: ' . $this->apiKey
        ]);

        // Habilitamos el seguimiento de información detallada
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $verbose = fopen('php://temp', 'w+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);

        // Ejecutamos la petición
        $resultado = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);

        // Obtenemos la información detallada
        rewind($verbose);
        $verboseLog = stream_get_contents($verbose);

        curl_close($ch);

        // Registramos la respuesta para diagnóstico
        $logRespuesta = "-------- RESPUESTA DE API HÁBLAME --------\n";
        $logRespuesta .= "Código HTTP: {$httpCode}\n";
        $logRespuesta .= "Respuesta bruta: " . substr($resultado, 0, 1000) . "\n";
        if (!empty($error)) {
            $logRespuesta .= "Error cURL: {$error}\n";
        }
        $logRespuesta .= "Información detallada: " . json_encode($info, JSON_PRETTY_PRINT) . "\n";
        $logRespuesta .= "Log verbose: \n{$verboseLog}\n";
        $logRespuesta .= "----------------------------------------\n";
        file_put_contents('api_debug.log', $logRespuesta, FILE_APPEND);

        // Si hay un error en la petición, lanzamos una excepción
        if ($resultado === false) {
            throw new Exception('Error en la conexión con la API: ' . $error);
        }

        // Retornamos la respuesta decodificada
        $respuesta = json_decode($resultado, true);

        // Si no pudimos decodificar la respuesta, devolvemos un array con la respuesta original
        if ($respuesta === null) {
            $jsonError = $this->obtenerErrorJson();
            return [
                'error' => true,
                'message' => 'No se pudo decodificar la respuesta de la API: ' . $jsonError,
                'rawResponse' => $resultado,
                'httpCode' => $httpCode,
                'requestData' => $datosEnviados
            ];
        }

        // Agregamos el código HTTP a la respuesta para referencia
        $respuesta['httpCode'] = $httpCode;

        return $respuesta;
    }

    /**
     * Obtiene el mensaje de error para problemas de decodificación JSON
     *
     * @return string Descripción del error JSON
     */
    private function obtenerErrorJson()
    {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return 'No hay error';
            case JSON_ERROR_DEPTH:
                return 'Se ha excedido la profundidad máxima de anidamiento';
            case JSON_ERROR_STATE_MISMATCH:
                return 'JSON inválido o mal formado';
            case JSON_ERROR_CTRL_CHAR:
                return 'Error de carácter de control';
            case JSON_ERROR_SYNTAX:
                return 'Error de sintaxis JSON';
            case JSON_ERROR_UTF8:
                return 'Caracteres UTF-8 mal formados';
            default:
                return 'Error desconocido: ' . json_last_error();
        }
    }

    /**
     * Procesa la respuesta de la API y valida si fue exitosa
     *
     * @param array $respuesta Respuesta de la API
     * @return array Respuesta procesada
     */
    private function procesarRespuesta($respuesta)
    {
        // Si la respuesta contiene un campo "error" que agregamos nosotros, la devolvemos tal cual
        if (isset($respuesta['error']) && $respuesta['error'] === true) {
            return $respuesta;
        }

        // Verificamos si la respuesta es exitosa según la documentación de Háblame
        if (isset($respuesta['status']) && $respuesta['status'] == 'success') {
            // La petición fue exitosa
            return [
                'status' => 'success',
                'message' => 'Mensaje enviado correctamente',
                'smsId' => isset($respuesta['smsId']) ? $respuesta['smsId'] : null,
                'campaignId' => isset($respuesta['campaignId']) ? $respuesta['campaignId'] : null,
                'rawResponse' => $respuesta
            ];
        } else {
            // La petición falló
            return [
                'status' => 'error',
                'message' => isset($respuesta['message']) ? $respuesta['message'] : 'Error desconocido',
                'errorCode' => isset($respuesta['errorCode']) ? $respuesta['errorCode'] : null,
                'rawResponse' => $respuesta
            ];
        }
    }

    /**
     * Establece la clave de API
     *
     * @param string $apiKey Nueva clave de API
     * @return void
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Establece el número remitente por defecto
     *
     * @param string $from Número remitente
     * @return void
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }
}

?>
