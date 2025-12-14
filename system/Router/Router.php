<?php

namespace Higgs\Router;

use Closure;
use Higgs\Exceptions\PageNotFoundException;
use Higgs\HTTP\Request;
use Higgs\Router\Exceptions\RedirectException;
use Higgs\Router\Exceptions\RouterException;

class Router implements RouterInterface
{
    protected $collection;
    protected $directory;
    protected $controller;
    protected $method;
    protected $params = [];
    protected $indexPage = 'index.php';
    protected $translateURIDashes = false;
    protected $matchedRoute;
    protected $matchedRouteOptions;
    protected $detectedLocale;
    protected $filterInfo;
    protected $filtersInfo = [];
    protected ?AutoRouterInterface $autoRouter = null;

    public function __construct(RouteCollectionInterface $routes, ?Request $request = null)
    {
        $this->collection = $routes;
        $this->controller = $this->collection->getDefaultController();
        $this->method = $this->collection->getDefaultMethod();
        $this->collection->setHTTPVerb(strtolower($request->getMethod() ?? $_SERVER['REQUEST_METHOD']));
        $this->translateURIDashes = $this->collection->shouldTranslateURIDashes();
        if ($this->collection->shouldAutoRoute()) {
            $autoRoutesImproved = config('Feature')->autoRoutesImproved ?? false;
            if ($autoRoutesImproved) {
                $this->autoRouter = new AutoRouterImproved($this->collection->getRegisteredControllers('*'), $this->collection->getDefaultNamespace(), $this->collection->getDefaultController(), $this->collection->getDefaultMethod(), $this->translateURIDashes, $this->collection->getHTTPVerb());
            } else {
                $this->autoRouter = new AutoRouter($this->collection->getRegisteredControllers('cli'), $this->collection->getDefaultNamespace(), $this->collection->getDefaultController(), $this->collection->getDefaultMethod(), $this->translateURIDashes, $this->collection->getHTTPVerb());
            }
        }
    }

    public function handle(?string $uri = null)
    {
        if ($uri === null || $uri === '') {
            return strpos($this->controller, '\\') === false ? $this->collection->getDefaultNamespace() . $this->controller : $this->controller;
        }
        $uri = urldecode($uri);
        $this->filterInfo = null;
        $this->filtersInfo = [];
        if ($this->checkRoutes($uri)) {
            if ($this->collection->isFiltered($this->matchedRoute[0])) {
                $multipleFiltersEnabled = config('Feature')->multipleFilters ?? false;
                if ($multipleFiltersEnabled) {
                    $this->filtersInfo = $this->collection->getFiltersForRoute($this->matchedRoute[0]);
                } else {
                    $this->filterInfo = $this->collection->getFilterForRoute($this->matchedRoute[0]);
                }
            }
            return $this->controller;
        }
        if (!$this->collection->shouldAutoRoute()) {
            throw new PageNotFoundException("Can't find a route for '{$this->collection->getHTTPVerb()}: {$uri}'.");
        }
        $this->autoRoute($uri);
        return $this->controllerName();
    }

    protected function checkRoutes(string $uri): bool
    {
        $routes = $this->collection->getRoutes($this->collection->getHTTPVerb());
        if (empty($routes)) {
            return false;
        }
        $uri = $uri === '/' ? $uri : trim($uri, '/ ');
        foreach ($routes as $routeKey => $handler) {
            $routeKey = $routeKey === '/' ? $routeKey : ltrim($routeKey, '/ ');
            $matchedKey = $routeKey;
            if (strpos($routeKey, '{locale}') !== false) {
                $routeKey = str_replace('{locale}', '[^/]+', $routeKey);
            }
            if (preg_match('#^' . $routeKey . '$#u', $uri, $matches)) {
                if ($this->collection->isRedirect($routeKey)) {
                    $redirectTo = preg_replace_callback('/(\([^\(]+\))/', static function () {
                        static $i = 1;
                        return '$' . $i++;
                    }, is_array($handler) ? key($handler) : $handler);
                    throw new RedirectException(preg_replace('#^' . $routeKey . '$#u', $redirectTo, $uri), $this->collection->getRedirectCode($routeKey));
                }
                if (strpos($matchedKey, '{locale}') !== false) {
                    preg_match('#^' . str_replace('{locale}', '(?<locale>[^/]+)', $matchedKey) . '$#u', $uri, $matched);
                    if ($this->collection->shouldUseSupportedLocalesOnly() && !in_array($matched['locale'], config('App')->supportedLocales, true)) {
                        throw PageNotFoundException::forLocaleNotSupported($matched['locale']);
                    }
                    $this->detectedLocale = $matched['locale'];
                    unset($matched);
                }
                if (!is_string($handler) && is_callable($handler)) {
                    $this->controller = $handler;
                    array_shift($matches);
                    $this->params = $matches;
                    $this->setMatchedRoute($matchedKey, $handler);
                    return true;
                }
                [$controller] = explode('::', $handler);
                if (strpos($controller, '/') !== false) {
                    throw RouterException::forInvalidControllerName($handler);
                }
                if (strpos($handler, '$') !== false && strpos($routeKey, '(') !== false) {
                    if (strpos($controller, '$') !== false) {
                        throw RouterException::forDynamicController($handler);
                    }
                    $handler = preg_replace('#^' . $routeKey . '$#u', $handler, $uri);
                }
                $this->setRequest(explode('/', $handler));
                $this->setMatchedRoute($matchedKey, $handler);
                return true;
            }
        }
        return false;
    }

    protected function setRequest(array $segments = [])
    {
        if (empty($segments)) {
            return;
        }
        [$controller, $method] = array_pad(explode('::', $segments[0]), 2, null);
        $this->controller = $controller;
        if (!empty($method)) {
            $this->method = $method;
        }
        array_shift($segments);
        $this->params = $segments;
    }

    public function autoRoute(string $uri)
    {
        [$this->directory, $this->controller, $this->method, $this->params] = $this->autoRouter->getRoute($uri);
    }

    public function controllerName()
    {
        return $this->translateURIDashes ? str_replace('-', '_', $this->controller) : $this->controller;
    }

    public function getFilter()
    {
        return $this->filterInfo;
    }

    public function getFilters(): array
    {
        return $this->filtersInfo;
    }

    public function methodName(): string
    {
        return $this->translateURIDashes ? str_replace('-', '_', $this->method) : $this->method;
    }

    public function get404Override()
    {
        $route = $this->collection->get404Override();
        if (is_string($route)) {
            $routeArray = explode('::', $route);
            return [$routeArray[0], $routeArray[1] ?? 'index',];
        }
        if (is_callable($route)) {
            return $route;
        }
        return null;
    }

    public function params(): array
    {
        return $this->params;
    }

    public function directory(): string
    {
        if ($this->autoRouter instanceof AutoRouter) {
            return $this->autoRouter->directory();
        }
        return '';
    }

    public function getMatchedRoute()
    {
        return $this->matchedRoute;
    }

    protected function setMatchedRoute(string $route, $handler): void
    {
        $this->matchedRoute = [$route, $handler];
        $this->matchedRouteOptions = $this->collection->getRoutesOptions($route);
    }

    public function getMatchedRouteOptions()
    {
        return $this->matchedRouteOptions;
    }

    public function setIndexPage($page): self
    {
        $this->indexPage = $page;
        return $this;
    }

    public function setTranslateURIDashes(bool $val = false): self
    {
        if ($this->autoRouter instanceof AutoRouter) {
            $this->autoRouter->setTranslateURIDashes($val);
            return $this;
        }
        return $this;
    }

    public function hasLocale()
    {
        return (bool)$this->detectedLocale;
    }

    public function getLocale()
    {
        return $this->detectedLocale;
    }

    protected function validateRequest(array $segments): array
    {
        return $this->scanControllers($segments);
    }

    protected function scanControllers(array $segments): array
    {
        $segments = array_filter($segments, static fn($segment) => $segment !== '');
        $segments = array_values($segments);
        if (isset($this->directory)) {
            return $segments;
        }
        $c = count($segments);
        while ($c-- > 0) {
            $segmentConvert = ucfirst($this->translateURIDashes === true ? str_replace('-', '_', $segments[0]) : $segments[0]);
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
        }
        if ($this->autoRouter instanceof AutoRouter) {
            $this->autoRouter->setDirectory($dir, $append, $validate);
        }
    }

    protected function setDefaultController()
    {
        if (empty($this->controller)) {
            throw RouterException::forMissingDefaultRoute();
        }
        sscanf($this->controller, '%[^/]/%s', $class, $this->method);
        if (!is_file(APPPATH . 'Controllers/' . $this->directory . ucfirst($class) . '.php')) {
            return;
        }
        $this->controller = ucfirst($class);
        log_message('info', 'Used the default controller.');
    }
}