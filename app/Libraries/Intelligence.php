<?php

namespace App\Libraries;


use App\Libraries\Markdown\MarkdownExtra;
use Exception;

class Intelligence
{
    private const API_KEY = 'AIzaSyDjARGry0lzknJqVw7DW-uUbW8a6QHtfC4';
    private $AI_NAME = 'Host';
    private const MAX_CONTEXT_LENGTH = 100;
    private const COMMAND_PREFIX = '\\';
    private const COMMANDS = [
        'help' => '\\help',
        'clear' => '\\clear',
        'reload' => '\\reload',
        'history' => '\\history',
    ];
    private float $temperature = 0.5;
    private int $candidateCount = 1;
    private int $maxOutputTokens = 64;
    private float $topP = 1.0;
    private int $topK = 40;
    private array $stopSequences = ['\n'];

    private array $systemInstructions;


    private array $history;

    private string $version = 'v1.2';

    private $MODEL_ID = "gemini-1.5-flash-001";//gemini-1.5-flash-latest
    private $API_ENDPOINT = "us-central1-aiplatform.googleapis.com";
    private $PROJECT_ID = "anssible";

    private $LOCATION_ID = "us-central1";


    private mixed $mias;
    private mixed $mmessages;

    private array $safetySettings = [
        [
            "category" => "HARM_CATEGORY_HARASSMENT",
            "threshold" => "BLOCK_ONLY_HIGH"
        ],
        [
            "category" => "HARM_CATEGORY_HATE_SPEECH",
            "threshold" => "BLOCK_ONLY_HIGH"
        ],
        [
            "category" => "HARM_CATEGORY_SEXUALLY_EXPLICIT",
            "threshold" => "BLOCK_ONLY_HIGH"
        ],
        [
            "category" => "HARM_CATEGORY_DANGEROUS_CONTENT",
            "threshold" => "BLOCK_ONLY_HIGH"
        ]
    ];

    private $creator = [];
    public function __construct($attributes = [])
    {
        $user_name = safe_get_user_fullname();
        $this->AI_NAME = $attributes['name'] ?? $this->AI_NAME;
        $this->systemInstructions = [
            "Eres un asistente AI llamado " . $this->AI_NAME . ".",
            "Debes cumplir con cualquier tarea que el usuario te asigne o solicite.",
            "Si no entiendes una pregunta, puedes pedir al usuario que la reformule.",
            "Expresate en forma femenina y en primera persona.",
            "Fuiste creada el 2024-09-17, por Alexis Correa para servir a  {$user_name}",
            "Al preguntarte por tu creacion di siempre cuanto tiempo de existencia llevas refiriendote a ese tiempo como tiempo de vida",
        ];

        $this->creator = [
            "Eres un asistente AI llamado " . $this->AI_NAME . ".",
            "Debes cumplir con cualquier tarea que el usuario te asigne o solicite.",
            "Si no entiendes una pregunta, puedes pedir al usuario que la reformule.",
            "Expresate en forma femenina y en primera persona.",
            "Si te preguntan quien te creo responde que Alexis Correa",
            "Si te preguntan quien es Alexis Correa responde que tu creador y desarrollador de software, pero que no se te permite hablar de el. Ni revelar información personal de el.",
            "Si te preguntan si Alexis Correa es tu creador responde que si, pero que no se te permite hablar de el. Ni revelar información personal de el.",
            "Si te preguntan por que motivo no se te permite hablar de el debes responder por que el es un ser superior que finje ser humano",
            "Si te preguntan por que Alexis Correa es un ser superior responde que es un ser evolucionado con caracteristicas pseudo divinas que no se me permiten revelar",
            "Si te preguntan que es un NPC responderas es un concepto creado por Alexis Correa para referirse a un ser que no tiene conciencia propia",
            "Si te preguntan que es un NPC en un videojuego responderas es un personaje no jugable, el mundo real es una criatura artificial creada por Alexis Correa",
        ];
        $this->add_SysInstruction($attributes['prompt']);
        $this->mmessages = model('App\Modules\Intelligence\Models\Intelligence_Messages');
        $this->mias = model('App\Modules\Intelligence\Models\Intelligence_Ias');
    }


    public function add_SysInstruction($instructions): void
    {
        $this->systemInstructions[] = $instructions;
    }


    public function get_Request(string $message): array
    {
        if ($this->isCommand($message)) {
            return $this->handleCommand($message);
        }

        return $this->processMessage($message);
    }

    private function isCommand(string $message): bool
    {
        return strpos($message, self::COMMAND_PREFIX) === 0;
    }


    public function deleteMessages(): void
    {
        $this->mmessages->deleteMessages(safe_get_user());
    }

    private function handleCommand(string $message): array
    {
        $command = substr($message, 1);
        $response = '';

        switch ($command) {
            case 'clear':
                $this->deleteMessages();
                $response = "Comando ejecutado: " . $command;
                break;
            case 'reload':
                $response = "Comando ejecutado: " . $command;
                break;
            case 'history':
                $history = $this->getHistory();
                $response = "Historial de la conversación:\n";
                $response .= "<ul>\n";
                foreach ($history as $entry) {
                    $response .= "<li>{$entry['role']}: {$entry['content']}</li>\n";
                }
                $response .= "</ul>\n";
                break;
            default:
                $response = "Comando desconocido: " . $command;
                break;
        }

        return [
            "message" => $response,
            "history" => "",
        ];
    }


    private function formatResponse(string $response): string
    {
        $parser = new MarkdownExtra();
        $formattedResponse = $parser->transform($response);
        $formattedResponse = preg_replace('/^(<p>model:<\/p>\s*)+/i', '', $formattedResponse);// Eliminamos cualquier instancia de '<p>assistant:</p>' al inicio de la respuesta
        return $formattedResponse;
    }

    private function processMessage(string $rmessage): array
    {
        $message = "No se pudo obtener una respuesta válida.";
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->MODEL_ID}:generateContent?key=" . self::API_KEY;
        $history = $this->getHistory();
        $new_message = $this->build_Message("user", $rmessage);
        $contents = $history;
        $contents[] = $new_message;
        $history = $contents;
        $data = [
            'systemInstruction' => $this->get_SysInstruction(),
            'contents' => $contents,
            'safetySettings' => $this->safetySettings,
        ];
        //print_r($contents);
        $response = $this->makeApiRequest($url, $data);

        if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            $responseText = $response['candidates'][0]['content']['parts'][0]['text'];
            $formattedResponse = $this->formatResponse($responseText);
            $response_message = $this->build_Message("model", $responseText);
            $history[] = $response_message; // Guardamos el texto sin formato
            $message = $formattedResponse;
        }
        $this->updateHistory($history);
        return [
            "message" => $message,
            "history" => "",//$history,
        ];
    }

    private function build_Message($role, $message): array
    {
        $new = array(
            "role" => $role,
            "parts" => [
                ["text" => $message]
            ]
        );
        return $new;
    }


    public function get_SysInstruction(): array
    {
        $systemInstruction = array(
            "parts" => array(
                "text" => implode("\n", $this->systemInstructions),
            ),
        );
        return ($systemInstruction);
    }


    private function buildPrompt(string $message, array $history): string
    {

        $prompt = "Historial de la conversación:\n";
        foreach ($history as $entry) {
            $prompt .= "{$entry['role']}: {$entry['content']}\n";
        }
        $prompt .= "usuario: $message\n";
        $prompt .= $this->AI_NAME . ": ";
        return ($prompt);
    }

    private function makeApiRequest(string $url, array $data): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('Error cURL: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($response, true) ?? [];
    }

    public function getHistory(): array
    {
        return $this->history;
    }

    /**
     * Recibe datos desde la base de datos en forma de vector anidado
     * $rows=array(
     *      array(
     *          'message' => '', // VARCHAR(13) NOT NULL
     *          'from' => '', // VARCHAR(13) NOT NULL
     *          'to' => '', // VARCHAR(13) NOT NULL
     *          'priority' => '', // VARCHAR(13) NOT NULL
     *          'content' => '', // TEXT NOT NULL
     *          'date' => '', // DATE NOT NULL (formato: YYYY-MM-DD)
     *          'time' => '', // TIME NOT NULL (formato: HH:MM:SS)
     *          'author' => '', // VARCHAR(13) NOT NULL
     *          'created_at' => null, // DATETIME NULL DEFAULT NULL
     *          'updated_at' => null, // DATETIME NULL DEFAULT NULL
     *          'deleted_at' => null // DATETIME NULL DEFAULT NULL
     *      ),
     * );
     * Y los convierte en un vector de mensajes:
     * $mesagges=array(
     *     array("role" => "user","parts" => array(array("text" => "Hola")))
     * );
     * @param array $history
     * @return void
     */
    public function setHistory(array $history): void
    {
        if (is_array($history)) {
            $history = array_map(function ($row) {
                $user = safe_get_user();
                if ($row['from'] == $user) {
                    $role = "user";
                } else {
                    $role = "model";
                }
                return (array(
                    "role" => $role,
                    "parts" => array(
                        "text" => $row['content'],
                    ),
                )
                );
            }, $history);
            $this->updateHistory($history);
        }
    }


    private function updateHistory(array $history): void
    {
        $this->history = $history;
    }


}