<?php

namespace Facebook\HttpClients;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Http\GraphRawResponse;

interface FacebookHttpClientInterface
{
    public function send($url, $method, $body, array $headers, $timeOut);
}