<?php

namespace Higgs\HTTP;

use Higgs\Cookie\CookieStore;
use Higgs\HTTP\Exceptions\HTTPException;
use Config\Services;

class RedirectResponse extends Response
{
    public function to(string $uri, ?int $code = null, string $method = 'auto')
    {
        if (strpos($uri, 'http') !== 0) {
            $uri = site_url($uri);
        }
        return $this->redirect($uri, $method, $code);
    }

    public function route(string $route, array $params = [], int $code = 302, string $method = 'auto')
    {
        $namedRoute = $route;
        $route = Services::routes()->reverseRoute($route, ...$params);
        if (!$route) {
            throw HTTPException::forInvalidRedirectRoute($namedRoute);
        }
        return $this->redirect(site_url($route), $method, $code);
    }

    public function back(?int $code = null, string $method = 'auto')
    {
        Services::session();
        return $this->redirect(previous_url(), $method, $code);
    }

    public function withInput()
    {
        $session = Services::session();
        $session->setFlashdata('_ci_old_input', ['get' => $_GET ?? [], 'post' => $_POST ?? [],]);
        $this->withErrors();
        return $this;
    }

    private function withErrors(): self
    {
        $validation = Services::validation();
        if ($validation->getErrors()) {
            $session = Services::session();
            $session->setFlashdata('_ci_validation_errors', $validation->getErrors());
        }
        return $this;
    }

    public function with(string $key, $message)
    {
        Services::session()->setFlashdata($key, $message);
        return $this;
    }

    public function withCookies()
    {
        $this->cookieStore = new CookieStore(Services::response()->getCookies());
        return $this;
    }

    public function withHeaders()
    {
        foreach (Services::response()->headers() as $name => $header) {
            $this->setHeader($name, $header->getValue());
        }
        return $this;
    }
}