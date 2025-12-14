<?php

namespace Higgs\Test;

use Higgs\Controller;
use Higgs\HTTP\IncomingRequest;
use Higgs\HTTP\ResponseInterface;
use Higgs\HTTP\URI;
use Config\App;
use Config\Services;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Throwable;

trait ControllerTester
{
    protected $appConfig;
    protected $request;
    protected $response;
    protected $logger;
    protected $controller;
    protected $uri = 'http://example.com';
    protected $body;

    public function controller(string $name)
    {
        if (!class_exists($name)) {
            throw new InvalidArgumentException('Invalid Controller: ' . $name);
        }
        $this->controller = new $name();
        $this->controller->initController($this->request, $this->response, $this->logger);
        return $this;
    }

    public function execute(string $method, ...$params)
    {
        if (!method_exists($this->controller, $method) || !is_callable([$this->controller, $method])) {
            throw new InvalidArgumentException('Method does not exist or is not callable in controller: ' . $method);
        }
        helper('url');
        $result = (new ControllerResponse())->setRequest($this->request)->setResponse($this->response);
        $response = null;
        try {
            ob_start();
            $response = $this->controller->{$method}(...$params);
        } catch (Throwable $e) {
            $code = $e->getCode();
            if ($code < 100 || $code >= 600) {
                throw $e;
            }
            $result->response()->setStatusCode($code);
        } finally {
            $output = ob_get_clean();
            if (isset($response) && $response instanceof ResponseInterface) {
                $result->setResponse($response);
            }
            if (is_string($response)) {
                $output = $response;
                $result->response()->setBody($output);
                $result->setBody($output);
            } elseif (!empty($response) && !empty($response->getBody())) {
                $result->setBody($response->getBody());
            } else {
                $result->setBody('');
            }
        }
        if (empty($result->response()->getStatusCode())) {
            $result->response()->setStatusCode(200);
        }
        return $result;
    }

    public function withConfig($appConfig)
    {
        $this->appConfig = $appConfig;
        return $this;
    }

    public function withResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    public function withLogger($logger)
    {
        $this->logger = $logger;
        return $this;
    }

    public function withUri(string $uri)
    {
        $this->uri = new URI($uri);
        return $this;
    }

    public function withBody($body)
    {
        $this->body = $body;
        return $this;
    }

    protected function setUpControllerTester(): void
    {
        if (empty($this->appConfig)) {
            $this->appConfig = config('App');
        }
        if (!$this->uri instanceof URI) {
            $this->uri = Services::uri($this->appConfig->baseURL ?? 'http://example.com/', false);
        }
        if (empty($this->request)) {
            $tempUri = Services::uri();
            Services::injectMock('uri', $this->uri);
            $this->withRequest(Services::request($this->appConfig, false)->setBody($this->body));
            Services::injectMock('uri', $tempUri);
        }
        if (empty($this->response)) {
            $this->response = Services::response($this->appConfig, false);
        }
        if (empty($this->logger)) {
            $this->logger = Services::logger();
        }
    }

    public function withRequest($request)
    {
        $this->request = $request;
        Services::injectMock('request', $request);
        return $this;
    }
}