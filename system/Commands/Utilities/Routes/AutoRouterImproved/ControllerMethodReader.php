<?php

namespace Higgs\Commands\Utilities\Routes\AutoRouterImproved;

use ReflectionClass;
use ReflectionMethod;

final class ControllerMethodReader
{
    private string $namespace;
    private array $httpMethods;

    public function __construct(string $namespace, array $httpMethods)
    {
        $this->namespace = $namespace;
        $this->httpMethods = $httpMethods;
    }

    public function read(string $class, string $defaultController = 'Home', string $defaultMethod = 'index'): array
    {
        $reflection = new ReflectionClass($class);
        if ($reflection->isAbstract()) {
            return [];
        }
        $classname = $reflection->getName();
        $classShortname = $reflection->getShortName();
        $output = [];
        $classInUri = $this->getUriByClass($classname);
        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->getName();
            foreach ($this->httpMethods as $httpVerb) {
                if (strpos($methodName, $httpVerb) === 0) {
                    $methodInUri = lcfirst(substr($methodName, strlen($httpVerb)));
                    if ($methodInUri === $defaultMethod) {
                        $routeWithoutController = $this->getRouteWithoutController($classShortname, $defaultController, $classInUri, $classname, $methodName, $httpVerb);
                        if ($routeWithoutController !== []) {
                            $output = [...$output, ...$routeWithoutController];
                            continue;
                        }
                        $output[] = ['method' => $httpVerb, 'route' => $classInUri, 'route_params' => '', 'handler' => '\\' . $classname . '::' . $methodName, 'params' => [],];
                        continue;
                    }
                    $route = $classInUri . '/' . $methodInUri;
                    $params = [];
                    $routeParams = '';
                    $refParams = $method->getParameters();
                    foreach ($refParams as $param) {
                        $required = true;
                        if ($param->isOptional()) {
                            $required = false;
                            $routeParams .= '[/..]';
                        } else {
                            $routeParams .= '/..';
                        }
                        $params[$param->getName()] = $required;
                    }
                    $output[] = ['method' => $httpVerb, 'route' => $route, 'route_params' => $routeParams, 'handler' => '\\' . $classname . '::' . $methodName, 'params' => $params,];
                }
            }
        }
        return $output;
    }

    private function getUriByClass(string $classname): string
    {
        $pattern = '/' . preg_quote($this->namespace, '/') . '/';
        $class = ltrim(preg_replace($pattern, '', $classname), '\\');
        $classParts = explode('\\', $class);
        $classPath = '';
        foreach ($classParts as $part) {
            $classPath .= lcfirst($part) . '/';
        }
        return rtrim($classPath, '/');
    }

    private function getRouteWithoutController(string $classShortname, string $defaultController, string $uriByClass, string $classname, string $methodName, string $httpVerb): array
    {
        $output = [];
        if ($classShortname === $defaultController) {
            $pattern = '#' . preg_quote(lcfirst($defaultController), '#') . '\z#';
            $routeWithoutController = rtrim(preg_replace($pattern, '', $uriByClass), '/');
            $routeWithoutController = $routeWithoutController ?: '/';
            $output[] = ['method' => $httpVerb, 'route' => $routeWithoutController, 'route_params' => '', 'handler' => '\\' . $classname . '::' . $methodName, 'params' => [],];
        }
        return $output;
    }
}