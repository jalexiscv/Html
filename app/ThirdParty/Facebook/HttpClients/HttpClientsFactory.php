<?php

namespace Facebook\HttpClients;

use GuzzleHttp\Client;
use InvalidArgumentException;
use Exception;

class HttpClientsFactory
{
    private function __construct()
    {
    }

    public static function createHttpClient($handler)
    {
        if (!$handler) {
            return self::detectDefaultClient();
        }
        if ($handler instanceof FacebookHttpClientInterface) {
            return $handler;
        }
        if ('stream' === $handler) {
            return new FacebookStreamHttpClient();
        }
        if ('curl' === $handler) {
            if (!extension_loaded('curl')) {
                throw new Exception('The cURL extension must be loaded in order to use the "curl" handler.');
            }
            return new FacebookCurlHttpClient();
        }
        if ('guzzle' === $handler && !class_exists('GuzzleHttp\Client')) {
            throw new Exception('The Guzzle HTTP client must be included in order to use the "guzzle" handler.');
        }
        if ($handler instanceof Client) {
            return new FacebookGuzzleHttpClient($handler);
        }
        if ('guzzle' === $handler) {
            return new FacebookGuzzleHttpClient();
        }
        throw new InvalidArgumentException('The http client handler must be set to "curl", "stream", "guzzle", be an instance of GuzzleHttp\Client or an instance of Facebook\HttpClients\FacebookHttpClientInterface');
    }

    private static function detectDefaultClient()
    {
        if (extension_loaded('curl')) {
            return new FacebookCurlHttpClient();
        }
        if (class_exists('GuzzleHttp\Client')) {
            return new FacebookGuzzleHttpClient();
        }
        return new FacebookStreamHttpClient();
    }
}