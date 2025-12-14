<?php

namespace Higgs\Filters;

use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;

interface FilterInterface
{
    public function before(RequestInterface $request, $arguments = null);

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null);
}