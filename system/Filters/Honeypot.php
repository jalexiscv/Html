<?php

namespace Higgs\Filters;

use Higgs\Honeypot\Exceptions\HoneypotException;
use Higgs\HTTP\IncomingRequest;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;
use Config\Services;

class Honeypot implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$request instanceof IncomingRequest) {
            return;
        }
        if (Services::honeypot()->hasContent($request)) {
            throw HoneypotException::isBot();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        Services::honeypot()->attachHoneypot($response);
    }
}