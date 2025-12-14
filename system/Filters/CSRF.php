<?php

namespace Higgs\Filters;

use Higgs\HTTP\IncomingRequest;
use Higgs\HTTP\RedirectResponse;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;
use Higgs\Security\Exceptions\SecurityException;
use Config\Services;

class CSRF implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$request instanceof IncomingRequest) {
            return;
        }
        $security = Services::security();
        try {
            $security->verify($request);
        } catch (SecurityException $e) {
            if ($security->shouldRedirect() && !$request->isAJAX()) {
                return redirect()->back()->with('error', $e->getMessage());
            }
            throw $e;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}