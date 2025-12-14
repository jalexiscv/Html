<?php

namespace App\Services;

require_once(APPPATH . 'ThirdParty/GuzzleHttp/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GoogleGenerativeAI
{
    private $apiKey;
    private $client;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => 'https://api.google.com/', // Ajusta esto según la URL de la API
            'headers' => [
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function startChat($model, $history, $temperature)
    {
        try {
            $response = $this->client->post('/path/to/chat/endpoint', [
                'json' => [
                    'model' => $model,
                    'history' => $history,
                    'generationConfig' => [
                        'temperature' => $temperature,
                    ],
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            // Manejar errores aquí
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                print_r($response);
                //$errorMessage = json_decode($response->getBody()->getContents(), true)['message'];
                //throw new \Exception($errorMessage, $response->getStatusCode());
            } else {
                throw new \Exception('An unexpected error occurred');
            }
        }
    }
}

