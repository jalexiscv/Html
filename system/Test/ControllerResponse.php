<?php

namespace Higgs\Test;

use Higgs\HTTP\ResponseInterface;
use Config\Services;

class ControllerResponse extends TestResponse
{
    protected $body;
    protected $dom;

    public function __construct()
    {
        parent::__construct(Services::response());
        $this->dom = &$this->domParser;
    }

    public function setResponse(ResponseInterface $response)
    {
        parent::setResponse($response);
        $this->body = $response->getBody() ?? '';
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody(string $body)
    {
        $this->body = $body;
        if ($body !== '') {
            $this->domParser->withString($body);
        }
        return $this;
    }
}