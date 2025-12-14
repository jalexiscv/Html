<?php

namespace Higgs\Test;

use Closure;
use Higgs\Filters\Exceptions\FilterException;
use Higgs\Filters\FilterInterface;
use Higgs\Filters\Filters;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;
use Higgs\Router\RouteCollection;
use Config\Filters as FiltersConfig;
use Config\Services;
use InvalidArgumentException;
use RuntimeException;

trait FilterTestTrait
{
    protected $request;
    protected $response;
    protected $filtersConfig;
    protected $filters;
    protected $collection;
    private $doneFilterSetUp = false;

    protected function setUpFilterTestTrait(): void
    {
        if ($this->doneFilterSetUp === true) {
            return;
        }
        $this->request ??= clone Services::request();
        $this->response ??= clone Services::response();
        $this->filtersConfig ??= config('Filters');
        $this->filters ??= new Filters($this->filtersConfig, $this->request, $this->response);
        if ($this->collection === null) {
            $this->collection = Services::routes()->loadRoutes();
        }
        $this->doneFilterSetUp = true;
    }

    protected function getFilterCaller($filter, string $position): Closure
    {
        if (!in_array($position, ['before', 'after'], true)) {
            throw new InvalidArgumentException('Invalid filter position passed: ' . $position);
        }
        if (is_string($filter)) {
            if (strpos($filter, '\\') === false) {
                if (!isset($this->filtersConfig->aliases[$filter])) {
                    throw new RuntimeException("No filter found with alias '{$filter}'");
                }
                $filter = $this->filtersConfig->aliases[$filter];
            }
            $filter = new $filter();
        }
        if (!$filter instanceof FilterInterface) {
            throw FilterException::forIncorrectInterface(get_class($filter));
        }
        $request = clone $this->request;
        if ($position === 'before') {
            return static fn(?array $params = null) => $filter->before($request, $params);
        }
        $response = clone $this->response;
        return static fn(?array $params = null) => $filter->after($request, $response, $params);
    }

    protected function assertFilter(string $route, string $position, string $alias): void
    {
        $filters = $this->getFiltersForRoute($route, $position);
        $this->assertContains($alias, $filters, "Filter '{$alias}' does not apply to '{$route}'.",);
    }

    protected function getFiltersForRoute(string $route, string $position): array
    {
        if (!in_array($position, ['before', 'after'], true)) {
            throw new InvalidArgumentException('Invalid filter position passed:' . $position);
        }
        $this->filters->reset();
        if ($routeFilters = $this->collection->getFiltersForRoute($route)) {
            $this->filters->enableFilters($routeFilters, $position);
        }
        $aliases = $this->filters->initialize($route)->getFilters();
        $this->filters->reset();
        return $aliases[$position];
    }

    protected function assertNotFilter(string $route, string $position, string $alias)
    {
        $filters = $this->getFiltersForRoute($route, $position);
        $this->assertNotContains($alias, $filters, "Filter '{$alias}' applies to '{$route}' when it should not.",);
    }

    protected function assertHasFilters(string $route, string $position)
    {
        $filters = $this->getFiltersForRoute($route, $position);
        $this->assertNotEmpty($filters, "No filters found for '{$route}' when at least one was expected.",);
    }

    protected function assertNotHasFilters(string $route, string $position)
    {
        $filters = $this->getFiltersForRoute($route, $position);
        $this->assertSame([], $filters, "Found filters for '{$route}' when none were expected: " . implode(', ', $filters) . '.',);
    }
}