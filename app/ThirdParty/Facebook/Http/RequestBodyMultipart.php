<?php

namespace Facebook\Http;

use Facebook\FileUpload\FacebookFile;

class RequestBodyMultipart implements RequestBodyInterface
{
    private $boundary;
    private $params;
    private $files = [];

    public function __construct(array $params = [], array $files = [], $boundary = null)
    {
        $this->params = $params;
        $this->files = $files;
        $this->boundary = $boundary ?: uniqid();
    }

    public function getBody()
    {
        $body = '';
        $params = $this->getNestedParams($this->params);
        foreach ($params as $k => $v) {
            $body .= $this->getParamString($k, $v);
        }
        foreach ($this->files as $k => $v) {
            $body .= $this->getFileString($k, $v);
        }
        $body .= "--{$this->boundary}--\r\n";
        return $body;
    }

    public function getBoundary()
    {
        return $this->boundary;
    }

    private function getFileString($name, FacebookFile $file)
    {
        return sprintf("--%s\r\nContent-Disposition: form-data; name=\"%s\"; filename=\"%s\"%s\r\n\r\n%s\r\n", $this->boundary, $name, $file->getFileName(), $this->getFileHeaders($file), $file->getContents());
    }

    private function getParamString($name, $value)
    {
        return sprintf("--%s\r\nContent-Disposition: form-data; name=\"%s\"\r\n\r\n%s\r\n", $this->boundary, $name, $value);
    }

    private function getNestedParams(array $params)
    {
        $query = http_build_query($params, null, '&');
        $params = explode('&', $query);
        $result = [];
        foreach ($params as $param) {
            list($key, $value) = explode('=', $param, 2);
            $result[urldecode($key)] = urldecode($value);
        }
        return $result;
    }

    protected function getFileHeaders(FacebookFile $file)
    {
        return "\r\nContent-Type: {$file->getMimetype()}";
    }
}