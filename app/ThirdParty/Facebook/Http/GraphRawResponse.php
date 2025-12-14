<?php

namespace Facebook\Http;
class GraphRawResponse
{
    protected $headers;
    protected $body;
    protected $httpResponseCode;

    public function __construct($headers, $body, $httpStatusCode = null)
    {
        if (is_numeric($httpStatusCode)) {
            $this->httpResponseCode = (int)$httpStatusCode;
        }
        if (is_array($headers)) {
            $this->headers = $headers;
        } else {
            $this->setHeadersFromString($headers);
        }
        $this->body = $body;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getHttpResponseCode()
    {
        return $this->httpResponseCode;
    }

    public function setHttpResponseCodeFromHeader($rawResponseHeader)
    {
        list($version, $status, $reason) = array_pad(explode(' ', $rawResponseHeader, 3), 3, null);
        $this->httpResponseCode = (int)$status;
    }

    protected function setHeadersFromString($rawHeaders)
    {
        $rawHeaders = str_replace("\r\n", "\n", $rawHeaders);
        $headerCollection = explode("\n\n", trim($rawHeaders));
        $rawHeader = array_pop($headerCollection);
        $headerComponents = explode("\n", $rawHeader);
        foreach ($headerComponents as $line) {
            if (strpos($line, ': ') === false) {
                $this->setHttpResponseCodeFromHeader($line);
            } else {
                list($key, $value) = explode(': ', $line, 2);
                $this->headers[$key] = $value;
            }
        }
    }
}