<?php

namespace Higgs\Commands\Utilities;

use Closure;
use Higgs\CLI\BaseCommand;
use Higgs\CLI\CLI;
use Higgs\Commands\Utilities\Routes\AutoRouteCollector;
use Higgs\Commands\Utilities\Routes\AutoRouterImproved\AutoRouteCollector as AutoRouteCollectorImproved;
use Higgs\Commands\Utilities\Routes\FilterCollector;
use Higgs\Commands\Utilities\Routes\SampleURIGenerator;
use Config\Services;

class Routes extends BaseCommand
{
    protected $group = 'Higgs';
    protected $name = 'routes';
    protected $description = 'Displays all routes.';
    protected $usage = 'routes';
    protected $arguments = [];
    protected $options = ['-h' => 'Sort by Handler.',];

    public function run(array $params)
    {
        $sortByHandler = array_key_exists('h', $params);
        $collection = Services::routes()->loadRoutes();
        $methods = ['get', 'head', 'post', 'patch', 'put', 'delete', 'options', 'trace', 'connect', 'cli',];
        $tbody = [];
        $uriGenerator = new SampleURIGenerator();
        $filterCollector = new FilterCollector();
        foreach ($methods as $method) {
            $routes = $collection->getRoutes($method);
            foreach ($routes as $route => $handler) {
                if (is_string($handler) || $handler instanceof Closure) {
                    $sampleUri = $uriGenerator->get($route);
                    $filters = $filterCollector->get($method, $sampleUri);
                    if ($handler instanceof Closure) {
                        $handler = '(Closure)';
                    }
                    $routeName = $collection->getRoutesOptions($route)['as'] ?? '»';
                    $tbody[] = [strtoupper($method), $route, $routeName, $handler, implode(' ', array_map('class_basename', $filters['before'])), implode(' ', array_map('class_basename', $filters['after'])),];
                }
            }
        }
        if ($collection->shouldAutoRoute()) {
            $autoRoutesImproved = config('Feature')->autoRoutesImproved ?? false;
            if ($autoRoutesImproved) {
                $autoRouteCollector = new AutoRouteCollectorImproved($collection->getDefaultNamespace(), $collection->getDefaultController(), $collection->getDefaultMethod(), $methods, $collection->getRegisteredControllers('*'));
                $autoRoutes = $autoRouteCollector->get();
            } else {
                $autoRouteCollector = new AutoRouteCollector($collection->getDefaultNamespace(), $collection->getDefaultController(), $collection->getDefaultMethod());
                $autoRoutes = $autoRouteCollector->get();
                foreach ($autoRoutes as &$routes) {
                    $filters = $filterCollector->get('auto', $uriGenerator->get($routes[1]));
                    $routes[] = implode(' ', array_map('class_basename', $filters['before']));
                    $routes[] = implode(' ', array_map('class_basename', $filters['after']));
                }
            }
            $tbody = [...$tbody, ...$autoRoutes];
        }
        $thead = ['Method', 'Route', 'Name', $sortByHandler ? 'Handler ↓' : 'Handler', 'Before Filters', 'After Filters',];
        if ($sortByHandler) {
            usort($tbody, static fn($handler1, $handler2) => strcmp($handler1[3], $handler2[3]));
        }
        CLI::table($tbody, $thead);
    }
}