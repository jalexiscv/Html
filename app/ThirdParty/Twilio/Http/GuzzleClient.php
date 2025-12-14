<?php

namespace Twilio\Http;

use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use Twilio\Exceptions\HttpException;
use function GuzzleHttp\Psr7\build_query;

final class GuzzleClient implements Client
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function request(string $method, string $url, array $params = [], array $data = [], array $headers = [], string $user = null, string $password = null, int $timeout = null): Response
    {
        try {
            $body = build_query($data, PHP_QUERY_RFC1738);
            $options = ['timeout' => $timeout, 'auth' => [$user, $password], 'body' => $body,];
            if ($params) {
                $options['query'] = $params;
            }
            $response = $this->client->send(new Request($method, $url, $headers), $options);
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
        } catch (Exception $exception) {
            throw new HttpException('Unable to complete the HTTP request', 0, $exception);
        }
        return new Response($response->getStatusCode(), (string)$response->getBody(), $response->getHeaders());
    }
}