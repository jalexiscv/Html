<?php

namespace SendGrid;
class Response
{
    protected $statusCode;
    protected $body;
    protected $headers;

    public function __construct($statusCode = 200, $body = '', array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = $headers;
    }

    public function statusCode()
    {
        return $this->statusCode;
    }

    public function body()
    {
        return $this->body;
    }

    public function headers($assoc = false)
    {
        if (!$assoc) {
            return $this->headers;
        }
        return $this->prettifyHeaders($this->headers);
    }

    private function prettifyHeaders(array $headers)
    {
        return array_reduce(array_filter($headers), function ($result, $header) {
            if (false === strpos($header, ':')) {
                $result['Status'] = trim($header);
                return $result;
            }
            list($key, $value) = explode(':', $header, 2);
            $result[trim($key)] = trim($value);
            return $result;
        }, []);
    }
}
