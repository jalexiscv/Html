<?php

namespace Facebook\HttpClients;

use Facebook\Http\GraphRawResponse;
use Facebook\Exceptions\FacebookSDKException;

class FacebookCurlHttpClient implements FacebookHttpClientInterface
{
    protected $curlErrorMessage = '';
    protected $curlErrorCode = 0;
    protected $rawResponse;
    protected $facebookCurl;

    public function __construct(FacebookCurl $facebookCurl = null)
    {
        $this->facebookCurl = $facebookCurl ?: new FacebookCurl();
    }

    public function send($url, $method, $body, array $headers, $timeOut)
    {
        $this->openConnection($url, $method, $body, $headers, $timeOut);
        $this->sendRequest();
        if ($curlErrorCode = $this->facebookCurl->errno()) {
            throw new FacebookSDKException($this->facebookCurl->error(), $curlErrorCode);
        }
        list($rawHeaders, $rawBody) = $this->extractResponseHeadersAndBody();
        $this->closeConnection();
        return new GraphRawResponse($rawHeaders, $rawBody);
    }

    public function openConnection($url, $method, $body, array $headers, $timeOut)
    {
        $options = [CURLOPT_CUSTOMREQUEST => $method, CURLOPT_HTTPHEADER => $this->compileRequestHeaders($headers), CURLOPT_URL => $url, CURLOPT_CONNECTTIMEOUT => 10, CURLOPT_TIMEOUT => $timeOut, CURLOPT_RETURNTRANSFER => true, CURLOPT_HEADER => true, CURLOPT_SSL_VERIFYHOST => 2, CURLOPT_SSL_VERIFYPEER => true, CURLOPT_CAINFO => __DIR__ . '/certs/DigiCertHighAssuranceEVRootCA.pem',];
        if ($method !== "GET") {
            $options[CURLOPT_POSTFIELDS] = $body;
        }
        $this->facebookCurl->init();
        $this->facebookCurl->setoptArray($options);
    }

    public function closeConnection()
    {
        $this->facebookCurl->close();
    }

    public function sendRequest()
    {
        $this->rawResponse = $this->facebookCurl->exec();
    }

    public function compileRequestHeaders(array $headers)
    {
        $return = [];
        foreach ($headers as $key => $value) {
            $return[] = $key . ': ' . $value;
        }
        return $return;
    }

    public function extractResponseHeadersAndBody()
    {
        $parts = explode("\r\n\r\n", $this->rawResponse);
        $rawBody = array_pop($parts);
        $rawHeaders = implode("\r\n\r\n", $parts);
        return [trim($rawHeaders), trim($rawBody)];
    }
}