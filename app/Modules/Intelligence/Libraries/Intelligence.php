<?php

namespace App\Modules\Intelligence\Libraries;

require_once(APPPATH . 'ThirdParty/GeminiAPI/autoload.php');

use GeminiAPI\Client as GeminiClient;
use GeminiAPI\Resources\ModelName;
use GeminiAPI\Resources\Parts\TextPart;

class Intelligence
{
    private $API_KEY;
    private $conversation = [];

    public function __construct()
    {
        $this->API_KEY = 'AIzaSyCxhICJiUd-ViN7Srs07VJod9OvknqYU14';
    }

    public function handleRequest($data, $files)
    {
        $message = $data['message'] ?? '';
        $processedFiles = $this->processFiles($files);

        // Add message to conversation history
        $this->conversation[] = ['role' => 'user', 'content' => $message];

        // Prepare API request
        $requestData = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [['text' => $message]]
                ]
            ]
        ];

        // Add image parts if present
        if (!empty($processedFiles)) {
            foreach ($processedFiles as $file) {
                $requestData['contents'][0]['parts'][] = [
                    'inline_data' => [
                        'mime_type' => $file['type'],
                        'data' => $file['base64']
                    ]
                ];
            }
        }

        // Make API request to Gemini
        $response = $this->makeGeminiRequest($requestData);

        // Add response to conversation history
        $this->conversation[] = ['role' => 'assistant', 'content' => $response];

        return [
            'response' => $response,
            'conversation' => $this->conversation
        ];
    }

    private function processFiles($files)
    {
        $processedFiles = [];

        if (empty($files)) {
            return $processedFiles;
        }

        foreach ($files as $file) {
            if (strpos($file['type'], 'image/') === 0) {
                $base64 = base64_encode(file_get_contents($file['tmp_name']));
                $processedFiles[] = [
                    'type' => $file['type'],
                    'base64' => $base64
                ];
            }
        }

        return $processedFiles;
    }


    private function makeGeminiRequest($data)
    {
        $client = new GeminiClient($this->API_KEY);
        $chat = $client->generativeModel(ModelName::GEMINI_PRO)->start_chat();
        $response = $chat->send(new TextPart('Hola, ¿cómo estás?'));
        echo $response->text() . "\n";
        $response = $chat->send(new TextPart('Y tú, ¿qué tal tu día?'));
        echo $response->text() . "\n";
    }


    private function makeGeminiRequestOLD($data)
    {
        //$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro-vision:generateContent?key=" . $this->apiKey;
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-001:generateContent?key=" . $this->API_KEY;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception("API request failed: " . $error);
        }

        $responseData = json_decode($response, true);
        return $responseData['candidates'][0]['content']['parts'][0]['text'] ?? 'No response from AI';
    }
}

?>