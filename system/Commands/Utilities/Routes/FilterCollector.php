<?php

namespace Higgs\Commands\Utilities\Routes;

use Higgs\Config\Services;
use Higgs\Filters\Filters;
use Higgs\HTTP\Request;
use Higgs\Router\Router;

final class FilterCollector
{
    private bool $resetRoutes;

    public function __construct(bool $resetRoutes = false)
    {
        $this->resetRoutes = $resetRoutes;
    }

    public function get(string $method, string $uri): array
    {
        if ($method === 'cli') {
            return ['before' => [], 'after' => [],];
        }
        $request = Services::request(null, false);
        $request->setMethod($method);
        $router = $this->createRouter($request);
        $filters = $this->createFilters($request);
        $finder = new FilterFinder($router, $filters);
        return $finder->find($uri);
    }

    private function createRouter(Request $request): Router
    {
        $routes = Services::routes();
        if ($this->resetRoutes) {
            $routes->resetRoutes();
        }
        return new Router($routes, $request);
    }

    private function createFilters(Request $request): Filters
    {
        $config = config('Filters');
        return new Filters($config, $request, Services::response());
    }
}