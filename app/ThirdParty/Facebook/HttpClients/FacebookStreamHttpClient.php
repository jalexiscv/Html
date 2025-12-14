<?php

namespace Facebook\HttpClients;

use Facebook\Http\GraphRawResponse;
use Facebook\Exceptions\FacebookSDKException;

class FacebookStreamHttpClient implements FacebookHttpClientInterface
{
    protected $facebookStream;

    public function __construct(FacebookStream $facebookStream = null)
    {
        $this->facebookStream = $facebookStream ?: new FacebookStream();
    }

    public function send($url, $method, $body, array $headers, $timeOut)
    {
        $options = ['http' => ['method' => $method, 'header' => $this->compileHeader($headers), 'content' => $body, 'timeout' => $timeOut, 'ignore_errors' => true], 'ssl' => ['verify_peer' => true, 'verify_peer_name' => true, 'allow_self_signed' => true, 'cafile' => __DIR__ . '/certs/DigiCertHighAssuranceEVRootCA.pem',],];
        $this->facebookStream->streamContextCreate($options);
        $rawBody = $this->facebookStream->fileGetContents($url);
        $rawHeaders = $this->facebookStream->getResponseHeaders();
        if ($rawBody === false || empty($rawHeaders)) {
            throw new FacebookSDKException('Stream returned an empty response', 660);
        }
        $rawHeaders = implode("\r\n", $rawHeaders);
        return new GraphRawResponse($rawHeaders, $rawBody);
    }

    public function compileHeader(array $headers)
    {
        $header = [];
        foreach ($headers as $k => $v) {
            $header[] = $k . ': ' . $v;
        }
        return implode("\r\n", $header);
    }
}