<?php
require_once(APPPATH . 'ThirdParty/Google2024/autoload.php');

use Google\Cloud\AIPlatform\V1\Client\PredictionServiceClient;
use Google\ApiCore\ApiException;

class GoogleAITextGenerator
{
    private $predictionServiceClient;
    private $projectId;
    private $location;
    private $model;

    public function __construct($credentialsPath)
    {
        // Configuración de credenciales y cliente
        $clientOptions = [
            'credentials' => json_decode(file_get_contents($credentialsPath), true),
            'apiEndpoint' => 'us-east5-aiplatform.googleapis.com'
        ];

        $this->predictionServiceClient = new PredictionServiceClient($clientOptions);
        $this->projectId = 'anssible';
        $this->location = 'us-east5';
        $this->model = 'claude-3-opus';
    }

    public function generateText($prompt)
    {
        try {
            // Preparar el modelo y los contenidos
            $model = \Google\Cloud\AIPlatform\V1\Client\PredictionServiceClient::projectLocationPublisherModelName(
                $this->projectId,
                $this->location,
                'anthropic',
                $this->model
            );

            // Crear la parte del contenido
            $part = (new \Google\Cloud\AIPlatform\V1\Part())->setText($prompt);
            $content = (new \Google\Cloud\AIPlatform\V1\Content())
                ->setParts([$part])
                ->setRole('user');

            // Crear la solicitud de generación de contenido
            $request = (new \Google\Cloud\AIPlatform\V1\GenerateContentRequest())
                ->setModel($model)
                ->setContents([$content]);

            // Generar contenido
            $response = $this->predictionServiceClient->generateContent($request);

            // Convertir respuesta a JSON para extraer texto
            $jsonResponse = $response->serializeToJsonString();
            $responseData = json_decode($jsonResponse, true);

            // Extraer y devolver el texto de respuesta
            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                return $responseData['candidates'][0]['content']['parts'][0]['text'];
            } else {
                throw new \Exception("No se encontró texto de respuesta");
            }

        } catch (ApiException $ex) {
            // Manejo de errores de API
            throw new \Exception("Error en la API: " . $ex->getMessage());
        }
    }
}

// Ejemplo de uso
try {
    // Ruta al archivo de credenciales
    $credentialsPath = APPPATH . 'ThirdParty/Google/keys.json';

    // Crear instancia del generador
    $aiGenerator = new GoogleAITextGenerator($credentialsPath);

    // Ejemplo de prompt
    $prompt = "Escribe un poema corto sobre la primavera";

    // Generar texto
    $generatedText = $aiGenerator->generateText($prompt);

    // Mostrar resultado
    echo "Texto generado:\n" . $generatedText;

} catch (\Exception $e) {
    // Manejo de errores
    echo "Error: " . $e->getMessage();
}



//[build]---------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$card = $bootstrap->get_Card("card-view-service", array(
    "title" => lang("Ias.view-title"),
    "header-back" => "",
    "content" => "",
));
echo($card);
?>