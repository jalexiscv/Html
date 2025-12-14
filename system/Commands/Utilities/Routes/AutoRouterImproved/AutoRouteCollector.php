<?php

namespace Higgs\Commands\Utilities\Routes\AutoRouterImproved;

use Higgs\Commands\Utilities\Routes\ControllerFinder;
use Higgs\Commands\Utilities\Routes\FilterCollector;

final class AutoRouteCollector
{
    private string $namespace;
    private string $defaultController;
    private string $defaultMethod;
    private array $httpMethods;
    private array $protectedControllers;

    public function __construct(string $namespace, string $defaultController, string $defaultMethod, array $httpMethods, array $protectedControllers)
    {
        $this->namespace = $namespace;
        $this->defaultController = $defaultController;
        $this->defaultMethod = $defaultMethod;
        $this->httpMethods = $httpMethods;
        $this->protectedControllers = $protectedControllers;
    }

    public function get(): array
    {
        $finder = new ControllerFinder($this->namespace);
        $reader = new ControllerMethodReader($this->namespace, $this->httpMethods);
        $tbody = [];
        foreach ($finder->find() as $class) {
            if (in_array('\\' . $class, $this->protectedControllers, true)) {
                continue;
            }
            $routes = $reader->read($class, $this->defaultController, $this->defaultMethod);
            if ($routes === []) {
                continue;
            }
            $routes = $this->addFilters($routes);
            foreach ($routes as $item) {
                $tbody[] = [strtoupper($item['method']) . '(auto)', $item['route'] . $item['route_params'], '', $item['handler'], $item['before'], $item['after'],];
            }
        }
        return $tbody;
    }

    private function addFilters($routes)
    {
        $filterCollector = new FilterCollector(true);
        foreach ($routes as &$route) {
            $sampleUri = $this->generateSampleUri($route);
            $filtersLongest = $filterCollector->get($route['method'], $route['route'] . $sampleUri);
            $sampleUri = $this->generateSampleUri($route, false);
            $filtersShortest = $filterCollector->get($route['method'], $route['route'] . $sampleUri);
            $filters['before'] = array_intersect($filtersLongest['before'], $filtersShortest['before']);
            $filters['after'] = array_intersect($filtersLongest['after'], $filtersShortest['after']);
            $route['before'] = implode(' ', array_map('class_basename', $filters['before']));
            $route['after'] = implode(' ', array_map('class_basename', $filters['after']));
        }
        return $routes;
    }

    private function generateSampleUri(array $route, bool $longest = true): string
    {
        $sampleUri = '';
        if (isset($route['params'])) {
            $i = 1;
            foreach ($route['params'] as $required) {
                if ($longest && !$required) {
                    $sampleUri .= '/' . $i++;
                }
            }
        }
        return $sampleUri;
    }
}