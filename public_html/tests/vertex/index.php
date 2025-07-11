<?php

require_once '../../../app/ThirdParty/Google/autoload.php';

use Google\Cloud\AIPlatform\V1\Client\PredictionServiceClient;
use Google\Cloud\AIPlatform\V1\PredictRequest;

// Configura los parámetros
$project = 'anssible';
$location = 'global';
$endpoint_id = 'claude-3-5-sonnet@20240620';

// Crea el cliente
$client = new PredictionServiceClient(['keyFilePath' => '../../../ThirdParty/GoogleAI/keys.json']);
// Create a request for your AI service
$request = new PredictRequest();
$request->setName('projects/anssible/locations/asia-east2/publishers/google/models/gemini-1.0-pro-002');
$request->setPayload([
    'text' => [
        'content' => 'What is the capital of France?',
        'mime_type' => 'text/plain',
    ],
]);

// Make the prediction request and get the response
$response = $client->predict($request);

