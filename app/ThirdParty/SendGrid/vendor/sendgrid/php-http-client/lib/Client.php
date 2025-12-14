<?php

namespace SendGrid;
class Client
{
    const TOO_MANY_REQUESTS_HTTP_CODE = 429;
    protected $host;
    protected $headers;
    protected $version;
    protected $path;
    protected $curlOptions;
    protected $isConcurrentRequest;
    protected $savedRequests;
    protected $retryOnLimit;
    private $methods = ['get', 'post', 'patch', 'put', 'delete'];

    public function __construct($host, $headers = null, $version = null, $path = null, $curlOptions = null, $retryOnLimit = false)
    {
        $this->host = $host;
        $this->headers = $headers ?: [];
        $this->version = $version;
        $this->path = $path ?: [];
        $this->curlOptions = $curlOptions ?: [];
        $this->retryOnLimit = $retryOnLimit;
        $this->isConcurrentRequest = false;
        $this->savedRequests = [];
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getCurlOptions()
    {
        return $this->curlOptions;
    }

    public function setCurlOptions(array $options)
    {
        $this->curlOptions = $options;
        return $this;
    }

    public function setRetryOnLimit($retry)
    {
        $this->retryOnLimit = $retry;
        return $this;
    }

    public function setIsConcurrentRequest($isConcurrent)
    {
        $this->isConcurrentRequest = $isConcurrent;
        return $this;
    }

    private function buildUrl($queryParams = null)
    {
        $path = '/' . implode('/', $this->path);
        if (isset($queryParams)) {
            $path .= '?' . http_build_query($queryParams);
        }
        return sprintf('%s%s%s', $this->host, $this->version ?: '', $path);
    }

    private function createCurlOptions($method, $body = null, $headers = null)
    {
        $options = [CURLOPT_RETURNTRANSFER => true, CURLOPT_HEADER => true, CURLOPT_CUSTOMREQUEST => strtoupper($method), CURLOPT_SSL_VERIFYPEER => true, CURLOPT_FAILONERROR => false] + $this->curlOptions;
        if (isset($headers)) {
            $headers = array_merge($this->headers, $headers);
        } else {
            $headers = $this->headers;
        }
        if (isset($body)) {
            $encodedBody = json_encode($body);
            $options[CURLOPT_POSTFIELDS] = $encodedBody;
            $headers = array_merge($headers, ['Content-Type: application/json']);
        }
        $options[CURLOPT_HTTPHEADER] = $headers;
        return $options;
    }

    private function createSavedRequest(array $requestData, $retryOnLimit = false)
    {
        return array_merge($requestData, ['retryOnLimit' => $retryOnLimit]);
    }

    private function createCurlMultiHandle(array $requests)
    {
        $channels = [];
        $multiHandle = curl_multi_init();
        foreach ($requests as $id => $data) {
            $channels[$id] = curl_init($data['url']);
            $curlOpts = $this->createCurlOptions($data['method'], $data['body'], $data['headers']);
            curl_setopt_array($channels[$id], $curlOpts);
            curl_multi_add_handle($multiHandle, $channels[$id]);
        }
        return [$channels, $multiHandle];
    }

    private function parseResponse($channel, $content)
    {
        $headerSize = curl_getinfo($channel, CURLINFO_HEADER_SIZE);
        $statusCode = curl_getinfo($channel, CURLINFO_HTTP_CODE);
        $responseBody = substr($content, $headerSize);
        $responseHeaders = substr($content, 0, $headerSize);
        $responseHeaders = explode("\n", $responseHeaders);
        $responseHeaders = array_map('trim', $responseHeaders);
        return new Response($statusCode, $responseBody, $responseHeaders);
    }

    private function retryRequest(array $responseHeaders, $method, $url, $body, $headers)
    {
        $sleepDurations = $responseHeaders['X-Ratelimit-Reset'] - time();
        sleep($sleepDurations > 0 ? $sleepDurations : 0);
        return $this->makeRequest($method, $url, $body, $headers, false);
    }

    public function makeRequest($method, $url, $body = null, $headers = null, $retryOnLimit = false)
    {
        $channel = curl_init($url);
        $options = $this->createCurlOptions($method, $body, $headers);
        curl_setopt_array($channel, $options);
        $content = curl_exec($channel);
        $response = $this->parseResponse($channel, $content);
        if ($response->statusCode() === self::TOO_MANY_REQUESTS_HTTP_CODE && $retryOnLimit) {
            $responseHeaders = $response->headers(true);
            return $this->retryRequest($responseHeaders, $method, $url, $body, $headers);
        }
        curl_close($channel);
        return $response;
    }

    public function makeAllRequests(array $requests = [])
    {
        if (empty($requests)) {
            $requests = $this->savedRequests;
        }
        list($channels, $multiHandle) = $this->createCurlMultiHandle($requests);
        $isRunning = null;
        do {
            curl_multi_exec($multiHandle, $isRunning);
        } while ($isRunning);
        $retryRequests = [];
        $responses = [];
        $sleepDurations = 0;
        foreach ($channels as $id => $channel) {
            $content = curl_multi_getcontent($channel);
            $response = $this->parseResponse($channel, $content);
            if ($response->statusCode() === self::TOO_MANY_REQUESTS_HTTP_CODE && $requests[$id]['retryOnLimit']) {
                $headers = $response->headers(true);
                $sleepDurations = max($sleepDurations, $headers['X-Ratelimit-Reset'] - time());
                $requestData = ['method' => $requests[$id]['method'], 'url' => $requests[$id]['url'], 'body' => $requests[$id]['body'], 'headers' => $headers,];
                $retryRequests[] = $this->createSavedRequest($requestData, false);
            } else {
                $responses[] = $response;
            }
            curl_multi_remove_handle($multiHandle, $channel);
        }
        curl_multi_close($multiHandle);
        if (!empty($retryRequests)) {
            sleep($sleepDurations > 0 ? $sleepDurations : 0);
            $responses = array_merge($responses, $this->makeAllRequests($retryRequests));
        }
        return $responses;
    }

    public function _($name = null)
    {
        if (isset($name)) {
            $this->path[] = $name;
        }
        $client = new static($this->host, $this->headers, $this->version, $this->path);
        $client->setCurlOptions($this->curlOptions);
        $client->setRetryOnLimit($this->retryOnLimit);
        $this->path = [];
        return $client;
    }

    public function __call($name, $args)
    {
        $name = strtolower($name);
        if ($name === 'version') {
            $this->version = $args[0];
            return $this->_();
        }
        if (($name === 'send') && $this->isConcurrentRequest) {
            return $this->makeAllRequests();
        }
        if (in_array($name, $this->methods, true)) {
            $body = isset($args[0]) ? $args[0] : null;
            $queryParams = isset($args[1]) ? $args[1] : null;
            $url = $this->buildUrl($queryParams);
            $headers = isset($args[2]) ? $args[2] : null;
            $retryOnLimit = isset($args[3]) ? $args[3] : $this->retryOnLimit;
            if ($this->isConcurrentRequest) {
                $requestData = ['method' => $name, 'url' => $url, 'body' => $body, 'headers' => $headers];
                $this->savedRequests[] = $this->createSavedRequest($requestData, $retryOnLimit);
                return null;
            }
            return $this->makeRequest($name, $url, $body, $headers, $retryOnLimit);
        }
        return $this->_($name);
    }
}
