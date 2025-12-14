<?php

namespace App\Modules\Intelligence\Controllers;

require_once(APPPATH . 'ThirdParty/GeminiAPI/autoload.php');

use GeminiAPI\Client;
use GeminiAPI\Resources\ModelName;
use GeminiAPI\Resources\Parts\TextPart;
use GeminiAPI\Resources\Content;
use GeminiAPI\Enums\Role;
use Higgs\API\ResponseTrait;
use Higgs\RESTful\ResourceController;
use App\Libraries\ChromaDB\ChromaDB;

/**
 * Api
 */
class Api extends ResourceController
{
    use ResponseTrait;

    public $namespace;
    protected $prefix;
    protected $module;
    protected $views;
    protected $viewer;
    protected $component;
    protected $GEMINI_API_KEY;

    public function __construct()
    {
        //header("Content-Type: text/json");
        $this->prefix = 'web-api';
        $this->module = 'App\Modules\Intelligence';
        $this->views = $this->module . '\Views';
        $this->viewer = $this->views . '\index';
        $this->component = $this->views . '\Api';
        helper($this->module . '\Helpers\Intelligence');
        helper('App\Helpers\Application');
        $this->GEMINI_API_KEY = 'AIzaSyCxhICJiUd-ViN7Srs07VJod9OvknqYU14';
    }

    // all users
    public function index()
    {
        $data = array("message" => "Api Online!");
        return $this->respond($data);
    }

    public function callbacks(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'request') {
                echo(view('App\Modules\Intelligence\Views\Request\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Intelligence.Api-breaches-no-option")));
        }
    }

    public function test(string $format, string $option, string $oid)
    {
        //header("Content-Type: text/json");
        header("Content-Type: text/html");
        $data = array(
            "oid" => $oid
        );
        if ($format == "json") {
            if ($option == 'list') {
                echo(view('App\Modules\Intelligence\Views\test\List\json', $data));
            }
        } else {
            return ($this->failNotFound(lang("Intelligence.Api-breaches-no-option")));
        }
    }

    /**
     * ## Usage Example
     * ```javascript
     * // Using fetch API
     * const formData = new FormData();
     * formData.append('message', 'Analyze this image');
     * formData.append('files', imageFile);
     *
     * const response = await fetch('/api/', {
     * method: 'POST',
     * body: formData
     * });
     *
     * const data = await response.json();
     * console.log(data.data.response);
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */


    /**
     * Cuando se crea el container el asigna un puerto interno y un puerto externo para acceder al servicio
     * en este caso fue 8000 a 32768 (público)
     * @param string $format
     * @param string $option
     * @param string $oid
     * @return void
     */


    public function direct(string $format, string $option, string $oid)
    {
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');
        //header('Access-Control-Allow-Methods: POST');
        //header('Access-Control-Allow-Headers: Content-Type');
        $GEMINI_API_KEY = 'AIzaSyCxhICJiUd-ViN7Srs07VJod9OvknqYU14';
        $request = service('request');
        $message = $request->getVar("message");
        $chromadb = new ChromaDB();
        $collection_name = 'conversations-roleds';
        $chromadb->createCollection($collection_name);
        $collection = $chromadb->getCollection($collection_name);
        //print_r($collection);
        $collection_id = $collection['id'];
        $ia = new Client($GEMINI_API_KEY);
        $embedding_response = $ia->embeddingModel(ModelName::EMBEDDING_001)->embedContent(new TextPart($message));
        $embeddings = $embedding_response->embedding->values;
        // echo(safe_dump($embeddings));
        // Find similar conversations in ChromaDB
        $similars = $chromadb->queryItems(collectionId: $collection_id, queryEmbeddings: [$embeddings], include: ['documents', 'metadatas', 'distances'], nResults: 100);
        //print_r($similars);
        $history = array();
        if ($similars['status']) {
            foreach ($similars['results']['documents'] as $documents) {
                foreach ($documents as $document) {
                    $json = json_decode($document);
                    foreach ($json as $item) {
                        $role = ($item->role === 'user') ? Role::User : Role::Model;
                        //echo("Content::text('{$item->text}',Role::".safe_ucfirst($item->role)."),\n");
                        $history[] = Content::text($item->text, $role);
                    }
                }
            }
        }
        //print_r($documents);
        //print_r($json);
        //print_r($history);

        $history2 = [
            Content::text('mi nombre es Alexis Correa', Role::User),
            Content::text('Hola mucho gusto Alexis', Role::Model),
        ];

        $history3 = [
            Content::text('mi nombre es Alexis Correa', Role::User),
            Content::text('Hola Alexis, encantado de conocerte. :)', Role::Model),
            Content::text('yo te dije que mi nombre es Alexis Correa', Role::User),
            Content::text('Lo siento, entendí mal. Encantado de conocerte, Alexis Correa.', Role::Model),
            Content::text('hola', Role::User),
            Content::text('Hola Alexis! ¿Cómo estás?', Role::Model),
            Content::text('hola como estas', Role::User),
            Content::text('Hola, estoy bien, gracias. Soy un modelo de lenguaje de IA, entrenado para ser informativo y servicial. ¿Cómo puedo ayudarte hoy?', Role::Model),
            Content::text('que es lo ultimo que recuerdas de nuestra conversacion', Role::User),
            Content::text('Como modelo de lenguaje de IA, no tengo la capacidad de recordar conversaciones pasadas o almacenar información sobre interacciones específicas. Por lo tanto, no puedo recuperar la última parte de nuestra conversación.', Role::Model),
            Content::text('que es lo ultimo que recuerdas de nuestra conversacion', Role::User),
            Content::text('Como modelo de lenguaje de IA, no tengo la capacidad de recordar conversaciones anteriores o almacenar información sobre interacciones específicas. Por lo tanto, no puedo recuperar la última parte de nuestra conversación.', Role::Model),
            Content::text('hola', Role::User),
            Content::text('Hola, ¿cómo puedo ayudarte hoy?', Role::Model),
        ];

        // Generate response with Gemini using context
        $chat = $ia
            ->generativeModel(ModelName::GEMINI_PRO)
            ->startChat()
            //->withSystemInstruction('Tu nombre es Aurora')
            ->withHistory($history3);
        $response = $chat->sendMessage(new TextPart($message));
        $generated_text = $response->text();

        // Store the complete conversation in ChromaDB in JSON format
        $conversation = array();
        $conversation[] = array('text' => $message, 'role' => 'user');
        $conversation[] = array('text' => $generated_text, 'role' => 'model');
        $json = json_encode($conversation);
        $embedding_final = $ia->embeddingModel(ModelName::EMBEDDING_001)->embedContent(new TextPart($message . $generated_text));
        $embeddings_saved = $embedding_final->embedding->values;
        $save = $chromadb->saveItems(collectionId: $collection_id, ids: ['itemx-' . uniqid()], documents: [$json], metadatas: [['title' => 'metadata1']], embeddings: [$embeddings_saved]);
        //print_r($save);
        echo json_encode([
            'success' => true,
            'response' => $generated_text,
            '$collection_id' => $collection_id,
            //'embedding' => $embeddings,
            'similars' => $similars,
        ]);
        //$save = $chromadb->saveItems(collectionId: $collection_id,ids: ['itemx-'.uniqid()],documents: [$message],metadatas: [['title' => 'metadata1']],embeddings: [$embeddings],);
        //print_r($save);
    }

    public function directOLD(string $format, string $option, string $oid)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Content-Type');

        $GEMINI_API_KEY = 'AIzaSyCxhICJiUd-ViN7Srs07VJod9OvknqYU14';
        $collection_name = 'conversations-dimensionals';

        $request = service('request');
        $message = $request->getVar("message");

        // CHROMADB
        $chromadb = new \HelgeSverre\Chromadb\Chromadb(
            token: 'test-token-chroma-local-dev',
            host: '34.133.165.149',
            port: '32768'
        );

        try {
            // Create collection if it doesn't exist
            $collections = $chromadb->collections();
            $collections->create(name: $collection_name);

            $collection = $collections->get(collectionName: $collection_name);
            $collection_id = $collection->json('id');

            $client = new Client($GEMINI_API_KEY);

            // Get embedding for the message
            $embedding_response = $client->embeddingModel(ModelName::EMBEDDING_001)
                ->embedContent(
                    new TextPart($message),
                );
            $embeddings = $embedding_response->embedding->values;

            // Find similar conversations in ChromaDB
            $similars = $chromadb->query($collection_id, $embeddings, 5);

            // Build context from similar conversations
            $history = [];
            foreach ($similars as $similar) {
                $history[] = $similar->document;
            }

            // Generate response with Gemini using context
            $chat = $client->generativeModel(ModelName::GEMINI_PRO)
                ->startChat()
                ->withHistory($history);
            $response = $chat->sendMessage(new TextPart($message));
            $generated_text = $response->text();

            // Store the complete conversation in ChromaDB
            $conversation = $message . "\n" . $generated_text;
            $chromadb->items()->upsert(
                collectionId: $collection_id,
                ids: [uniqid()], // You can use a more unique ID here
                embeddings: [$embeddings],
                documents: [$conversation]
            );

            echo json_encode([
                'success' => true,
                '$collection_id' => $collection_id,
                //'embedding' => $embeddings,
                'similars' => $similars,
                'response' => $generated_text
            ]);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Error interno del servidor: ' . $e->getMessage()]);
        }
    }

    public function directBasic(string $format, string $option, string $oid)
    {
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');
        //header('Access-Control-Allow-Methods: POST');
        //header('Access-Control-Allow-Headers: Content-Type');
        $chromadb = new \HelgeSverre\Chromadb\Chromadb(
            token: 'test-token-chroma-local-dev',
            host: '34.133.165.149',
            port: '32768'
        );
        // Create a new collection with optional metadata
        $chromadb->collections()->create(name: 'default_tenant');

// Count the number of collections
        $chromadb->collections()->count();
        echo json_encode([
            'success' => true,
            'data' => 'Chromadb',
            'collections_count' => $chromadb->collections()->count()
        ]);
    }

    public function directMultiTurn(string $format, string $option, string $oid)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Content-Type');
        $GEMINI_API_KEY = 'AIzaSyCxhICJiUd-ViN7Srs07VJod9OvknqYU14';
        $request = service('request');
        $message = $request->getVar("message");
        if (!empty($message)) {
            $files = $request->getFileMultiple("files");
            $client = new Client($GEMINI_API_KEY);
            $chat = $client->generativeModel(ModelName::GEMINI_PRO)->startChat();
            $response = $chat->sendMessage(new TextPart('Mi nombre es Alexis'));
            $response = $chat->sendMessage(new TextPart($message));
            echo json_encode(['success' => true, 'data' => $response->text()]);
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Debe enviarse un mensaje']);
        }
    }

    public function directWithSystemInstruction(string $format, string $option, string $oid)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Content-Type');
        $GEMINI_API_KEY = 'AIzaSyCxhICJiUd-ViN7Srs07VJod9OvknqYU14';
        $request = service('request');
        $message = $request->getVar("message");
        if (!empty($message)) {
            $files = $request->getFileMultiple("files");
            $client = new Client($GEMINI_API_KEY);
            $response = $client->withV1BetaVersion()
                ->generativeModel(ModelName::GEMINI_1_5_FLASH)
                ->withSystemInstruction('Tu nombre es Aurora')
                ->generateContent(
                    new TextPart($message),
                );
            echo json_encode(['success' => true, 'data' => $response]);
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Debe enviarse un mensaje']);
        }
    }

}
