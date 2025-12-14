<?php

namespace Facebook\Http;
class RequestBodyUrlEncoded implements RequestBodyInterface
{
    protected $params = [];

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function getBody()
    {
        return http_build_query($this->params, null, '&');
    }
}