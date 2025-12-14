<?php

namespace Higgs\Router;

use Higgs\Exceptions\PageNotFoundException;

final class AutoRouter implements AutoRouterInterface
{
    private array $protectedControllers;
    private ?string $directory = null;
    private string $controller;
    private string $method;
    private bool $translateURIDashes;
    private string $httpVerb;
    private string $defaultNamespace;

    public function __construct(array $protectedControllers, string $defaultNamespace, string $defaultController, string $defaultMethod, bool $translateURIDashes, string $httpVerb)
    {
        $this->protectedControllers = $protectedControllers;
        $this->defaultNamespace = $defaultNamespace;
        $this->translateURIDashes = $translateURIDashes;
        $this->httpVerb = $httpVerb;
        $this->controller = $defaultController;
        $this->method = $defaultMethod;
    }

    public function getRoute(string $uri): array
    {
        $segments = explode('/', $uri);
        $segments = $this->scanControllers($segments);
        if (!empty($segments)) {
            $this->controller = ucfirst(array_shift($segments));
        }
        $controllerName = $this->controllerName();
        if (!$this->isValidSegment($controllerName)) {
            throw new PageNotFoundException($this->controller . ' is not a valid controller name');
        }
        if (!empty($segments)) {
            $this->method = array_shift($segments) ?: $this->method;
        }
        if (strtolower($this->method) === 'initcontroller') {
            throw PageNotFoundException::forPageNotFound();
        }
        $params = [];
        if (!empty($segments)) {
            $params = $segments;
        }
        if ($this->httpVerb !== 'cli') {
            $controller = '\\' . $this->defaultNamespace;
            $controller .= $this->directory ? str_replace('/', '\\', $this->directory) : '';
            $controller .= $controllerName;
            $controller = strtolower($controller);
            foreach ($this->protectedControllers as $controllerInRoute) {
                if (!is_string($controllerInRoute)) {
                    continue;
                }
                if (strtolower($controllerInRoute) !== $controller) {
                    continue;
                }
                throw new PageNotFoundException('Cannot access the controller in a CLI Route. Controller: ' . $controllerInRoute);
            }
        }
        $file = APPPATH . 'Controllers/' . $this->directory . $controllerName . '.php';
        if (is_file($file)) {
            include_once $file;
        }
        if (strpos($this->controller, '\\') === false && strlen($this->defaultNamespace) > 1) {
            $this->controller = '\\' . ltrim(str_replace('/', '\\', $this->defaultNamespace . $this->directory . $controllerName), '\\');
        }
        return [$this->directory, $this->controllerName(), $this->methodName(), $params];
    }

    private function scanControllers(array $segments): array
    {
        $segments = array_filter($segments, static fn($segment) => $segment !== '');
        $segments = array_values($segments);
        if (isset($this->directory)) {
            return $segments;
        }
        $c = count($segments);
        while ($c-- > 0) {
            $segmentConvert = ucfirst($this->translateURIDashes ? str_replace('-', '_', $segments[0]) : $segments[0]);
            if (!$this->isValidSegment($segmentConvert)) {
                return $segments;
            }
            $test = APPPATH . 'Controllers/' . $this->directory . $segmentConvert;
            if (!is_file($test . '.php') && is_dir($test)) {
                $this->setDirectory($segmentConvert, true, false);
                array_shift($segments);
                continue;
            }
            return $segments;
        }
        return $segments;
    }

    private function isValidSegment(string $segment): bool
    {
        return (bool)preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $segment);
    }

    public function setDirectory(?string $dir = null, bool $append = false, bool $validate = true)
    {
        if (empty($dir)) {
            $this->directory = null;
            return;
        }
        if ($validate) {
            $segments = explode('/', trim($dir, '/'));
            foreach ($segments as $segment) {
                if (!$this->isValidSegment($segment)) {
                    return;
                }
            }
        }
        if ($append !== true || empty($this->directory)) {
            $this->directory = trim($dir, '/') . '/';
        } else {
            $this->directory .= trim($dir, '/') . '/';
        }
    }

    private function controllerName(): string
    {
        return $this->translateURIDashes ? str_replace('-', '_', $this->controller) : $this->controller;
    }

    private function methodName(): string
    {
        return $this->translateURIDashes ? str_replace('-', '_', $this->method) : $this->method;
    }

    public function setTranslateURIDashes(bool $val = false): self
    {
        $this->translateURIDashes = $val;
        return $this;
    }

    public function directory(): string
    {
        return !empty($this->directory) ? $this->directory : '';
    }
}