<?php

namespace App\Libraries;

require_once(APPPATH . 'ThirdParty/Mongo/autoload.php');

use \Config\MongoConfig;

use MongoDB\BSON\Regex;
use MongoDB\Client as client;
use MongoCollection;

class Mongo
{
    private $client;
    private $database;

    function __construct()
    {
        $uri = 'mongodb://10.128.0.44:27017';
        $database = 'databreaches';
        if (empty($uri) || empty($database)) {
            show_error('You need to declare URI and DB!');
        }
        try {
            $this->client = new \MongoDB\Client($uri);
        } catch (MongoDB\Driver\Exception\MongoConnectionException $ex) {
            show_error('Couldn\'t connect to database: ' . $ex->getMessage(), 500);
        }
        try {
            $this->database = $this->client->selectDatabase($database);
        } catch (MongoDB\Driver\Exception\RuntimeException $ex) {
            show_error('Error while fetching database with name: ' . $database . $ex->getMessage(), 500);
        }
    }

    function getDatabase()
    {
        return $this->database;
    }
}

?>