<?php

namespace Higgs\Commands\Utilities\Routes;

use Higgs\Exceptions\PageNotFoundException;
use Higgs\Filters\Filters;
use Higgs\Router\Exceptions\RedirectException;
use Higgs\Router\Router;
use Config\Services;

final class FilterFinder
{
    private Router $router;
    private Filters $filters;

    public function __construct(?Router $router = null, ?Filters $filters = null)
    {
        $this->router = $router ?? Services::router();
        $this->filters = $filters ?? Services::filters();
    }

    public function find(string $uri): array
    {
        $this->filters->reset();
        try {
            $routeFilters = $this->getRouteFilters($uri);
            $this->filters->enableFilters($routeFilters, 'before');
            $this->filters->enableFilters($routeFilters, 'after');
            $this->filters->initialize($uri);
            return $this->filters->getFilters();
        } catch (RedirectException $e) {
            return ['before' => [], 'after' => [],];
        } catch (PageNotFoundException $e) {
            return ['before' => ['<unknown>'], 'after' => ['<unknown>'],];
        }
    }

    private function getRouteFilters(string $uri): array
    {
        $this->router->handle($uri);
        $multipleFiltersEnabled = config('Feature')->multipleFilters ?? false;
        if (!$multipleFiltersEnabled) {
            $filter = $this->router->getFilter();
            return $filter === null ? [] : [$filter];
        }
        return $this->router->getFilters();
    }
}