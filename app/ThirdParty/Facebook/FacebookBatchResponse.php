<?php

namespace Facebook;

use ArrayIterator;
use IteratorAggregate;
use ArrayAccess;

class FacebookBatchResponse extends FacebookResponse implements IteratorAggregate, ArrayAccess
{
    protected $batchRequest;
    protected $responses = [];

    public function __construct(FacebookBatchRequest $batchRequest, FacebookResponse $response)
    {
        $this->batchRequest = $batchRequest;
        $request = $response->getRequest();
        $body = $response->getBody();
        $httpStatusCode = $response->getHttpStatusCode();
        $headers = $response->getHeaders();
        parent::__construct($request, $body, $httpStatusCode, $headers);
        $responses = $response->getDecodedBody();
        $this->setResponses($responses);
    }

    public function getResponses()
    {
        return $this->responses;
    }

    public function setResponses(array $responses)
    {
        $this->responses = [];
        foreach ($responses as $key => $graphResponse) {
            $this->addResponse($key, $graphResponse);
        }
    }

    public function addResponse($key, $response)
    {
        $originalRequestName = isset($this->batchRequest[$key]['name']) ? $this->batchRequest[$key]['name'] : $key;
        $originalRequest = isset($this->batchRequest[$key]['request']) ? $this->batchRequest[$key]['request'] : null;
        $httpResponseBody = isset($response['body']) ? $response['body'] : null;
        $httpResponseCode = isset($response['code']) ? $response['code'] : null;
        $httpResponseHeaders = isset($response['headers']) ? $this->normalizeBatchHeaders($response['headers']) : [];
        $this->responses[$originalRequestName] = new FacebookResponse($originalRequest, $httpResponseBody, $httpResponseCode, $httpResponseHeaders);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->responses);
    }

    public function offsetSet($offset, $value)
    {
        $this->addResponse($offset, $value);
    }

    public function offsetExists($offset)
    {
        return isset($this->responses[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->responses[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->responses[$offset]) ? $this->responses[$offset] : null;
    }

    private function normalizeBatchHeaders(array $batchHeaders)
    {
        $headers = [];
        foreach ($batchHeaders as $header) {
            $headers[$header['name']] = $header['value'];
        }
        return $headers;
    }
}