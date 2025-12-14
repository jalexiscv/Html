<?php

namespace Higgs\Test;

use Higgs\Events\Events;
use Higgs\HTTP\IncomingRequest;
use Higgs\HTTP\Request;
use Higgs\HTTP\URI;
use Higgs\HTTP\UserAgent;
use Higgs\Router\Exceptions\RedirectException;
use Higgs\Router\RouteCollection;
use Config\Services;
use Exception;
use ReflectionException;

class FeatureTestCase extends CIUnitTestCase
{
    use DatabaseTestTrait;

    public function withSession(?array $values = null)
    {
        $this->session = $values ?? $_SESSION;
        return $this;
    }

    public function withHeaders(array $headers = [])
    {
        $this->headers = $headers;
        return $this;
    }

    public function withBodyFormat(string $format)
    {
        $this->bodyFormat = $format;
        return $this;
    }

    public function withBody($body)
    {
        $this->requestBody = $body;
        return $this;
    }

    public function skipEvents()
    {
        Events::simulate(true);
        return $this;
    }

    public function get(string $path, ?array $params = null)
    {
        return $this->call('get', $path, $params);
    }

    public function call(string $method, string $path, ?array $params = null)
    {
        $buffer = \ob_get_level();
        if (\ob_get_level() > 0 && (!isset($this->clean) || $this->clean === true)) {
            \ob_end_clean();
        }
        $_SESSION = [];
        $_SERVER['REQUEST_METHOD'] = $method;
        $request = $this->setupRequest($method, $path);
        $request = $this->setupHeaders($request);
        $request = $this->populateGlobals($method, $request, $params);
        $request = $this->setRequestBody($request);
        if (!$routes = $this->routes) {
            $routes = Services::routes()->loadRoutes();
        }
        $routes->setHTTPVerb($method);
        Services::injectMock('request', $request);
        Services::injectMock('filters', Services::filters(null, false));
        $response = $this->app->setContext('web')->setRequest($request)->run($routes, true);
        $output = \ob_get_contents();
        if (empty($response->getBody()) && !empty($output)) {
            $response->setBody($output);
        }
        Services::router()->setDirectory(null);
        while (\ob_get_level() > $buffer) {
            \ob_end_clean();
        }
        while (\ob_get_level() < $buffer) {
            \ob_start();
        }
        return new FeatureResponse($response);
    }

    protected function setupRequest(string $method, ?string $path = null): IncomingRequest
    {
        $config = config('App');
        $uri = new URI(rtrim($config->baseURL, '/') . '/' . trim($path, '/ '));
        $request = new IncomingRequest($config, clone $uri, null, new UserAgent());
        $request->uri = $uri;
        $request->setMethod($method);
        $request->setProtocolVersion('1.1');
        if ($config->forceGlobalSecureRequests) {
            $_SERVER['HTTPS'] = 'test';
        }
        return $request;
    }

    protected function setupHeaders(IncomingRequest $request)
    {
        foreach ($this->headers as $name => $value) {
            $request->setHeader($name, $value);
        }
        return $request;
    }

    protected function populateGlobals(string $method, Request $request, ?array $params = null)
    {
        $get = !empty($params) && $method === 'get' ? $params : $this->getPrivateProperty($request->getUri(), 'query');
        $request->setGlobal('get', $get);
        if ($method !== 'get') {
            $request->setGlobal($method, $params);
        }
        $request->setGlobal('request', $params);
        $_SESSION = $this->session ?? [];
        return $request;
    }

    protected function setRequestBody(Request $request, ?array $params = null): Request
    {
        if (isset($this->requestBody) && $this->requestBody !== '') {
            $request->setBody($this->requestBody);
            return $request;
        }
        if (isset($this->bodyFormat) && $this->bodyFormat !== '') {
            if (empty($params)) {
                $params = $request->fetchGlobal('request');
            }
            $formatMime = '';
            if ($this->bodyFormat === 'json') {
                $formatMime = 'application/json';
            } elseif ($this->bodyFormat === 'xml') {
                $formatMime = 'application/xml';
            }
            if (!empty($formatMime) && !empty($params)) {
                $formatted = Services::format()->getFormatter($formatMime)->format($params);
                $request->setBody($formatted);
                $request->setHeader('Content-Type', $formatMime);
            }
        }
        return $request;
    }

    public function post(string $path, ?array $params = null)
    {
        return $this->call('post', $path, $params);
    }

    public function put(string $path, ?array $params = null)
    {
        return $this->call('put', $path, $params);
    }

    public function patch(string $path, ?array $params = null)
    {
        return $this->call('patch', $path, $params);
    }

    public function delete(string $path, ?array $params = null)
    {
        return $this->call('delete', $path, $params);
    }

    public function options(string $path, ?array $params = null)
    {
        return $this->call('options', $path, $params);
    }

    protected function withRoutes(?array $routes = null)
    {
        $collection = Services::routes();
        if ($routes) {
            $collection->resetRoutes();
            foreach ($routes as $route) {
                $collection->{$route[0]}($route[1], $route[2]);
            }
        }
        $this->routes = $collection;
        return $this;
    }
}