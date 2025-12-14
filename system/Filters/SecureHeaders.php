<?php

namespace Higgs\Filters;

use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;

class SecureHeaders implements FilterInterface
{
    protected $headers = ['X-Frame-Options' => 'SAMEORIGIN', 'X-Content-Type-Options' => 'nosniff', 'X-Download-Options' => 'noopen', 'X-Permitted-Cross-Domain-Policies' => 'none', 'Referrer-Policy' => 'same-origin',];

    public function before(RequestInterface $request, $arguments = null)
    {
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        foreach ($this->headers as $header => $value) {
            $response->setHeader($header, $value);
        }
    }
}