<?php

namespace Higgs\Test;

use Higgs\Controller;
use Higgs\HTTP\Exceptions\HTTPException;
use Higgs\HTTP\IncomingRequest;
use Higgs\HTTP\ResponseInterface;
use Higgs\HTTP\URI;
use Config\App;
use Config\Services;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Throwable;

trait ControllerTestTrait
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
        $response = null;
        $this->request->setBody($this->body);
        try {
            ob_start();
            $response = $this->controller->{$method}(...$params);
        } catch (Throwable $e) {
            $code = $e->getCode();
            if ($code < 100 || $code >= 600) {
                throw $e;
            }
        } finally {
            $output = ob_get_clean();
        }
        if (is_string($response)) {
            $output = is_string($output) ? $output . $response : $response;
        }
        if (!$response instanceof ResponseInterface) {
            $response = $this->response;
        }
        if (is_string($output)) {
            if (is_string($response->getBody())) {
                $response->setBody($output . $response->getBody());
            } else {
                $response->setBody($output);
            }
        }
        if (isset($code)) {
            $response->setStatusCode($code);
        } else {
            try {
                $response->getStatusCode();
            } catch (HTTPException $e) {
                $response->setStatusCode(200);
            }
        }
        return (new TestResponse($response))->setRequest($this->request);
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

    protected function setUpControllerTestTrait(): void
    {
        helper('url');
        if (empty($this->appConfig)) {
            $this->appConfig = config('App');
        }
        if (!$this->uri instanceof URI) {
            $this->uri = Services::uri($this->appConfig->baseURL ?? 'http://example.com/', false);
        }
        if (empty($this->request)) {
            $tempUri = Services::uri();
            Services::injectMock('uri', $this->uri);
            $this->withRequest(Services::request($this->appConfig, false));
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