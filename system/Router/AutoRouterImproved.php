<?php

namespace Higgs\Router;

use Higgs\Exceptions\PageNotFoundException;
use ReflectionClass;
use ReflectionException;

final class AutoRouterImproved implements AutoRouterInterface
{
    private array $protectedControllers;
    private ?string $directory = null;
    private ?string $subNamespace = null;
    private string $controller;
    private string $method;
    private array $params = [];
    private bool $translateURIDashes;
    private string $httpVerb;
    private string $namespace;
    private string $defaultController;
    private string $defaultMethod;

    public function __construct(array $protectedControllers, string $namespace, string $defaultController, string $defaultMethod, bool $translateURIDashes, string $httpVerb)
    {
        $this->protectedControllers = $protectedControllers;
        $this->namespace = rtrim($namespace, '\\') . '\\';
        $this->translateURIDashes = $translateURIDashes;
        $this->httpVerb = $httpVerb;
        $this->defaultController = $defaultController;
        $this->defaultMethod = $httpVerb . ucfirst($defaultMethod);
        $this->controller = $this->defaultController;
        $this->method = $this->defaultMethod;
    }

    public function getRoute(string $uri): array
    {
        $segments = explode('/', $uri);
        $nonDirSegments = $this->scanControllers($segments);
        $controllerSegment = '';
        $baseControllerName = $this->defaultController;
        if (!empty($nonDirSegments)) {
            $controllerSegment = array_shift($nonDirSegments);
            $baseControllerName = $this->translateURIDashes(ucfirst($controllerSegment));
        }
        if (!$this->isValidSegment($baseControllerName)) {
            throw new PageNotFoundException($baseControllerName . ' is not a valid controller name');
        }
        if (strtolower($baseControllerName) === strtolower($this->defaultController) && strtolower($controllerSegment) === strtolower($this->defaultController)) {
            throw new PageNotFoundException('Cannot access the default controller "' . $baseControllerName . '" with the controller name URI path.');
        }
        if (!empty($nonDirSegments)) {
            $methodSegment = $this->translateURIDashes(array_shift($nonDirSegments));
            $this->method = $this->httpVerb . ucfirst($methodSegment);
            if (strtolower($this->method) === strtolower($this->defaultMethod)) {
                throw new PageNotFoundException('Cannot access the default method "' . $this->method . '" with the method name URI path.');
            }
        }
        if (!empty($nonDirSegments)) {
            $this->params = $nonDirSegments;
        }
        $this->controller = '\\' . ltrim(str_replace('/', '\\', $this->namespace . $this->subNamespace . $baseControllerName), '\\');
        $this->protectDefinedRoutes();
        $this->checkRemap();
        try {
            $this->checkParameters($uri);
        } catch (ReflectionException $e) {
            throw PageNotFoundException::forControllerNotFound($this->controller, $this->method);
        }
        return [$this->directory, $this->controller, $this->method, $this->params];
    }

    private function scanControllers(array $segments): array
    {
        $segments = array_filter($segments, static fn($segment) => $segment !== '');
        $segments = array_values($segments);
        $c = count($segments);
        while ($c-- > 0) {
            $segmentConvert = $this->translateURIDashes(ucfirst($segments[0]));
            if (!$this->isValidSegment($segmentConvert)) {
                return $segments;
            }
            $test = $this->namespace . $this->subNamespace . $segmentConvert;
            if (!class_exists($test)) {
                $this->setSubNamespace($segmentConvert, true, false);
                array_shift($segments);
                $this->directory .= $this->directory . $segmentConvert . '/';
                continue;
            }
            return $segments;
        }
        return $segments;
    }

    private function translateURIDashes(string $classname): string
    {
        return $this->translateURIDashes ? str_replace('-', '_', $classname) : $classname;
    }

    private function isValidSegment(string $segment): bool
    {
        return (bool)preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $segment);
    }

    private function setSubNamespace(?string $namespace = null, bool $append = false, bool $validate = true): void
    {
        if ($validate) {
            $segments = explode('/', trim($namespace, '/'));
            foreach ($segments as $segment) {
                if (!$this->isValidSegment($segment)) {
                    return;
                }
            }
        }
        if ($append !== true || empty($this->subNamespace)) {
            $this->subNamespace = trim($namespace, '/') . '\\';
        } else {
            $this->subNamespace .= trim($namespace, '/') . '\\';
        }
    }

    private function protectDefinedRoutes(): void
    {
        $controller = strtolower($this->controller);
        foreach ($this->protectedControllers as $controllerInRoutes) {
            $routeLowerCase = strtolower($controllerInRoutes);
            if ($routeLowerCase === $controller) {
                throw new PageNotFoundException('Cannot access the controller in Defined Routes. Controller: ' . $controllerInRoutes);
            }
        }
    }

    private function checkRemap(): void
    {
        try {
            $refClass = new ReflectionClass($this->controller);
            $refClass->getMethod('_remap');
            throw new PageNotFoundException('AutoRouterImproved does not support `_remap()` method.' . ' Controller:' . $this->controller);
        } catch (ReflectionException $e) {
        }
    }

    private function checkParameters(string $uri): void
    {
        $refClass = new ReflectionClass($this->controller);
        $refMethod = $refClass->getMethod($this->method);
        $refParams = $refMethod->getParameters();
        if (!$refMethod->isPublic()) {
            throw PageNotFoundException::forMethodNotFound($this->method);
        }
        if (count($refParams) < count($this->params)) {
            throw new PageNotFoundException('The param count in the URI are greater than the controller method params.' . ' Handler:' . $this->controller . '::' . $this->method . ', URI:' . $uri);
        }
    }
}