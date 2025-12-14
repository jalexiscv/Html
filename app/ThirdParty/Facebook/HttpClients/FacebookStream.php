<?php

namespace Facebook\HttpClients;
class FacebookStream
{
    protected $stream;
    protected $responseHeaders = [];

    public function streamContextCreate(array $options)
    {
        $this->stream = stream_context_create($options);
    }

    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    public function fileGetContents($url)
    {
        $rawResponse = file_get_contents($url, false, $this->stream);
        $this->responseHeaders = $http_response_header ?: [];
        return $rawResponse;
    }
}