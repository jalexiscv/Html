<?php

namespace App\Controllers;

require_once(APPPATH . 'ThirdParty/Google/autoload.php');

use App\Services\GoogleGenerativeAI;
use Higgs\HTTP\Response;

class Ai extends BaseController
{
    public function index()
    {
        $credentials = json_decode(file_get_contents(APPPATH . 'ThirdParty/Google/keys.json'), true);

// Crea un cliente de API
        $client = new Google_Client();
        $client->setAuthConfig($credentials);
        $client->addScope('https://www.googleapis.com/auth/cloud-platform');

// Crea un servicio de Gemini
        $gemini = new Google_Service_Gemini($client);

// Define la solicitud de Gemini
        $request = new Google_Service_Gemini_GenerateTextRequest();
        $request->setModel('gemini-1.5-pro-latest');
        $request->setPrompt('¿Cuál es la capital de Francia?');

// Envía la solicitud y recibe la respuesta
        $response = $gemini->projects_locations_models->generateText($request);

// Imprime la respuesta
        echo $response->getText();
    }
}

