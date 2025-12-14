<?php

namespace Higgs\Router;

use Closure;
use Higgs\Autoloader\FileLocator;
use Higgs\Router\Exceptions\RouterException;
use Config\App;
use Config\Modules;
use Config\Services;
use InvalidArgumentException;
use Locale;

class RouteCollection implements RouteCollectionInterface
{
    protected $defaultNamespace = '\\';
    protected $defaultController = 'Home';
    protected $defaultMethod = 'index';
    protected $defaultPlaceholder = 'any';
    protected $translateURIDashes = false;
    protected $autoRoute = false;
    protected $override404;
    protected $placeholders = ['any' => '.*', 'segment' => '[^/]+', 'alphanum' => '[a-zA-Z0-9]+', 'num' => '[0-9]+', 'alpha' => '[a-zA-Z]+', 'hash' => '[^/]+',];
    protected $routes = ['*' => [], 'options' => [], 'get' => [], 'head' => [], 'post' => [], 'put' => [], 'delete' => [], 'trace' => [], 'connect' => [], 'cli' => [],];
    protected $routesOptions = [];
    protected $HTTPVerb = '*';
    protected $defaultHTTPMethods = ['options', 'get', 'head', 'post', 'put', 'delete', 'trace', 'connect', 'cli',];
    protected $group;
    protected $currentSubdomain;
    protected $currentOptions;
    protected $didDiscover = false;
    protected $fileLocator;
    protected $moduleConfig;
    protected $prioritize = false;
    protected $prioritizeDetected = false;
    protected bool $useSupportedLocalesOnly = false;
    private ?string $httpHost = null;

    public function __construct(FileLocator $locator, Modules $moduleConfig)
    {
        $this->fileLocator = $locator;
        $this->moduleConfig = $moduleConfig;
        $this->httpHost = Services::request()->getServer('HTTP_HOST');
    }

    public function loadRoutes(string $routesFile = APPPATH . 'Config/Routes.php')
    {
        if ($this->didDiscover) {
            return $this;
        }
        $routes = $this;
        require $routesFile;
        $this->discoverRoutes();
        return $this;
    }

    protected function discoverRoutes()
    {
        if ($this->didDiscover) {
            return;
        }
        $routes = $this;
        if ($this->moduleConfig->shouldDiscover('routes')) {
            $files = $this->fileLocator->search('Config/Routes.php');
            $excludes = [APPPATH . 'Config' . DIRECTORY_SEPARATOR . 'Routes.php', SYSTEMPATH . 'Config' . DIRECTORY_SEPARATOR . 'Routes.php',];
            foreach ($files as $file) {
                if (in_array($file, $excludes, true)) {
                    continue;
                }
                include $file;
            }
        }
        $this->didDiscover = true;
    }

    public function addPlaceholder($placeholder, ?string $pattern = null): RouteCollectionInterface
    {
        if (!is_array($placeholder)) {
            $placeholder = [$placeholder => $pattern];
        }
        $this->placeholders = array_merge($this->placeholders, $placeholder);
        return $this;
    }

    public function getPlaceholders(): array
    {
        return $this->placeholders;
    }

    public function setTranslateURIDashes(bool $value): RouteCollectionInterface
    {
        $this->translateURIDashes = $value;
        return $this;
    }

    public function setAutoRoute(bool $value): RouteCollectionInterface
    {
        $this->autoRoute = $value;
        return $this;
    }

    public function set404Override($callable = null): RouteCollectionInterface
    {
        $this->override404 = $callable;
        return $this;
    }

    public function get404Override()
    {
        return $this->override404;
    }

    public function setDefaultConstraint(string $placeholder): RouteCollectionInterface
    {
        if (array_key_exists($placeholder, $this->placeholders)) {
            $this->defaultPlaceholder = $placeholder;
        }
        return $this;
    }

    public function getDefaultController(): string
    {
        return $this->defaultController;
    }

    public function setDefaultController(string $value): RouteCollectionInterface
    {
        $this->defaultController = esc(strip_tags($value));
        return $this;
    }

    public function getDefaultMethod(): string
    {
        return $this->defaultMethod;
    }

    public function setDefaultMethod(string $value): RouteCollectionInterface
    {
        $this->defaultMethod = esc(strip_tags($value));
        return $this;
    }

    public function getDefaultNamespace(): string
    {
        return $this->defaultNamespace;
    }

    public function setDefaultNamespace(string $value): RouteCollectionInterface
    {
        $this->defaultNamespace = esc(strip_tags($value));
        $this->defaultNamespace = rtrim($this->defaultNamespace, '\\') . '\\';
        return $this;
    }

    public function shouldTranslateURIDashes(): bool
    {
        return $this->translateURIDashes;
    }

    public function shouldAutoRoute(): bool
    {
        return $this->autoRoute;
    }

    public function map(array $routes = [], ?array $options = null): RouteCollectionInterface
    {
        foreach ($routes as $from => $to) {
            $this->add($from, $to, $options);
        }
        return $this;
    }

    public function add(string $from, $to, ?array $options = null): RouteCollectionInterface
    {
        $this->create('*', $from, $to, $options);
        return $this;
    }

    protected function create(string $verb, string $from, $to, ?array $options = null)
    {
        $overwrite = false;
        $prefix = $this->group === null ? '' : $this->group . '/';
        $from = esc(strip_tags($prefix . $from));
        if ($from !== '/') {
            $from = trim($from, '/');
        }
        if (is_array($to) && count($to) === 2) {
            $to = $this->processArrayCallableSyntax($from, $to);
        }
        $options = array_merge($this->currentOptions ?? [], $options ?? []);
        if (isset($options['priority'])) {
            $options['priority'] = abs((int)$options['priority']);
            if ($options['priority'] > 0) {
                $this->prioritizeDetected = true;
            }
        }
        if (!empty($options['hostname'])) {
            if (isset($this->httpHost) && strtolower($this->httpHost) !== strtolower($options['hostname'])) {
                return;
            }
            $overwrite = true;
        } elseif (!empty($options['subdomain'])) {
            if (!$this->checkSubdomains($options['subdomain'])) {
                return;
            }
            $overwrite = true;
        }
        if (isset($options['offset']) && is_string($to)) {
            $to = preg_replace('/(\$\d+)/', '$X', $to);
            for ($i = (int)$options['offset'] + 1; $i < (int)$options['offset'] + 7; $i++) {
                $to = preg_replace_callback('/\$X/', static fn($m) => '$' . $i, $to, 1);
            }
        }
        foreach ($this->placeholders as $tag => $pattern) {
            $from = str_ireplace(':' . $tag, $pattern, $from);
        }
        if (!isset($options['redirect']) && is_string($to)) {
            if (strpos($to, '\\') === false || strpos($to, '\\') > 0) {
                $namespace = $options['namespace'] ?? $this->defaultNamespace;
                $to = trim($namespace, '\\') . '\\' . $to;
            }
            $to = '\\' . ltrim($to, '\\');
        }
        $name = $options['as'] ?? $from;
        helper('array');
        $fromExists = dot_array_search('*.route.' . $from, $this->routes[$verb] ?? []) !== null;
        if ((isset($this->routes[$verb][$name]) || $fromExists) && !$overwrite) {
            return;
        }
        $this->routes[$verb][$name] = ['route' => [$from => $to],];
        $this->routesOptions[$verb][$from] = $options;
        if (isset($options['redirect']) && is_numeric($options['redirect'])) {
            $this->routes['*'][$name]['redirect'] = $options['redirect'];
        }
    }

    private function processArrayCallableSyntax(string $from, array $to): string
    {
        if (is_callable($to, true, $callableName)) {
            $params = $this->getMethodParams($from);
            return '\\' . $callableName . $params;
        }
        if (isset($to[0], $to[1]) && is_callable($to[0], true, $callableName) && is_string($to[1])) {
            $to = '\\' . $callableName . '/' . $to[1];
        }
        return $to;
    }

    private function getMethodParams(string $from): string
    {
        preg_match_all('/\(.+?\)/', $from, $matches);
        $count = is_countable($matches[0]) ? count($matches[0]) : 0;
        $params = '';
        for ($i = 1; $i <= $count; $i++) {
            $params .= '/$' . $i;
        }
        return $params;
    }

    private function checkSubdomains($subdomains): bool
    {
        if (!isset($this->httpHost)) {
            return false;
        }
        if ($this->currentSubdomain === null) {
            $this->currentSubdomain = $this->determineCurrentSubdomain();
        }
        if (!is_array($subdomains)) {
            $subdomains = [$subdomains];
        }
        if (!empty($this->currentSubdomain) && in_array('*', $subdomains, true)) {
            return true;
        }
        return in_array($this->currentSubdomain, $subdomains, true);
    }

    private function determineCurrentSubdomain()
    {
        $url = $this->httpHost;
        if (strpos($url, 'http') !== 0) {
            $url = 'http://' . $url;
        }
        $parsedUrl = parse_url($url);
        $host = explode('.', $parsedUrl['host']);
        if ($host[0] === 'www') {
            unset($host[0]);
        }
        unset($host[count($host) - 1]);
        if (end($host) === 'co') {
            $host = array_slice($host, 0, -1);
        }
        if (count($host) === 1) {
            return false;
        }
        return array_shift($host);
    }

    public function addRedirect(string $from, string $to, int $status = 302)
    {
        if (array_key_exists($to, $this->routes['*'])) {
            $to = $this->routes['*'][$to]['route'];
        } elseif (array_key_exists($to, $this->routes['get'])) {
            $to = $this->routes['get'][$to]['route'];
        }
        $this->create('*', $from, $to, ['redirect' => $status]);
        return $this;
    }

    public function isRedirect(string $from): bool
    {
        foreach ($this->routes['*'] as $name => $route) {
            if ($name === $from || key($route['route']) === $from) {
                return isset($route['redirect']) && is_numeric($route['redirect']);
            }
        }
        return false;
    }

    public function getRedirectCode(string $from): int
    {
        foreach ($this->routes['*'] as $name => $route) {
            if ($name === $from || key($route['route']) === $from) {
                return $route['redirect'] ?? 0;
            }
        }
        return 0;
    }

    public function group(string $name, ...$params)
    {
        $oldGroup = $this->group;
        $oldOptions = $this->currentOptions;
        $this->group = $name ? trim($oldGroup . '/' . $name, '/') : $oldGroup;
        $callback = array_pop($params);
        if ($params && is_array($params[0])) {
            $this->currentOptions = array_shift($params);
        }
        if (is_callable($callback)) {
            $callback($this);
        }
        $this->group = $oldGroup;
        $this->currentOptions = $oldOptions;
    }

    public function resource(string $name, ?array $options = null): RouteCollectionInterface
    {
        $newName = implode('\\', array_map('ucfirst', explode('/', $name)));
        if (isset($options['controller'])) {
            $newName = ucfirst(esc(strip_tags($options['controller'])));
        }
        $id = $options['placeholder'] ?? $this->placeholders[$this->defaultPlaceholder] ?? '(:segment)';
        $id = '(' . trim($id, '()') . ')';
        $methods = isset($options['only']) ? (is_string($options['only']) ? explode(',', $options['only']) : $options['only']) : ['index', 'show', 'create', 'update', 'delete', 'new', 'edit'];
        if (isset($options['except'])) {
            $options['except'] = is_array($options['except']) ? $options['except'] : explode(',', $options['except']);
            foreach ($methods as $i => $method) {
                if (in_array($method, $options['except'], true)) {
                    unset($methods[$i]);
                }
            }
        }
        if (in_array('index', $methods, true)) {
            $this->get($name, $newName . '::index', $options);
        }
        if (in_array('new', $methods, true)) {
            $this->get($name . '/new', $newName . '::new', $options);
        }
        if (in_array('edit', $methods, true)) {
            $this->get($name . '/' . $id . '/edit', $newName . '::edit/$1', $options);
        }
        if (in_array('show', $methods, true)) {
            $this->get($name . '/' . $id, $newName . '::show/$1', $options);
        }
        if (in_array('create', $methods, true)) {
            $this->post($name, $newName . '::create', $options);
        }
        if (in_array('update', $methods, true)) {
            $this->put($name . '/' . $id, $newName . '::update/$1', $options);
            $this->patch($name . '/' . $id, $newName . '::update/$1', $options);
        }
        if (in_array('delete', $methods, true)) {
            $this->delete($name . '/' . $id, $newName . '::delete/$1', $options);
        }
        if (isset($options['websafe'])) {
            if (in_array('delete', $methods, true)) {
                $this->post($name . '/' . $id . '/delete', $newName . '::delete/$1', $options);
            }
            if (in_array('update', $methods, true)) {
                $this->post($name . '/' . $id, $newName . '::update/$1', $options);
            }
        }
        return $this;
    }

    public function get(string $from, $to, ?array $options = null): RouteCollectionInterface
    {
        $this->create('get', $from, $to, $options);
        return $this;
    }

    public function post(string $from, $to, ?array $options = null): RouteCollectionInterface
    {
        $this->create('post', $from, $to, $options);
        return $this;
    }

    public function put(string $from, $to, ?array $options = null): RouteCollectionInterface
    {
        $this->create('put', $from, $to, $options);
        return $this;
    }

    public function patch(string $from, $to, ?array $options = null): RouteCollectionInterface
    {
        $this->create('patch', $from, $to, $options);
        return $this;
    }

    public function delete(string $from, $to, ?array $options = null): RouteCollectionInterface
    {
        $this->create('delete', $from, $to, $options);
        return $this;
    }

    public function presenter(string $name, ?array $options = null): RouteCollectionInterface
    {
        $newName = implode('\\', array_map('ucfirst', explode('/', $name)));
        if (isset($options['controller'])) {
            $newName = ucfirst(esc(strip_tags($options['controller'])));
        }
        $id = $options['placeholder'] ?? $this->placeholders[$this->defaultPlaceholder] ?? '(:segment)';
        $id = '(' . trim($id, '()') . ')';
        $methods = isset($options['only']) ? (is_string($options['only']) ? explode(',', $options['only']) : $options['only']) : ['index', 'show', 'new', 'create', 'edit', 'update', 'remove', 'delete'];
        if (isset($options['except'])) {
            $options['except'] = is_array($options['except']) ? $options['except'] : explode(',', $options['except']);
            foreach ($methods as $i => $method) {
                if (in_array($method, $options['except'], true)) {
                    unset($methods[$i]);
                }
            }
        }
        if (in_array('index', $methods, true)) {
            $this->get($name, $newName . '::index', $options);
        }
        if (in_array('show', $methods, true)) {
            $this->get($name . '/show/' . $id, $newName . '::show/$1', $options);
        }
        if (in_array('new', $methods, true)) {
            $this->get($name . '/new', $newName . '::new', $options);
        }
        if (in_array('create', $methods, true)) {
            $this->post($name . '/create', $newName . '::create', $options);
        }
        if (in_array('edit', $methods, true)) {
            $this->get($name . '/edit/' . $id, $newName . '::edit/$1', $options);
        }
        if (in_array('update', $methods, true)) {
            $this->post($name . '/update/' . $id, $newName . '::update/$1', $options);
        }
        if (in_array('remove', $methods, true)) {
            $this->get($name . '/remove/' . $id, $newName . '::remove/$1', $options);
        }
        if (in_array('delete', $methods, true)) {
            $this->post($name . '/delete/' . $id, $newName . '::delete/$1', $options);
        }
        if (in_array('show', $methods, true)) {
            $this->get($name . '/' . $id, $newName . '::show/$1', $options);
        }
        if (in_array('create', $methods, true)) {
            $this->post($name, $newName . '::create', $options);
        }
        return $this;
    }

    public function match(array $verbs = [], string $from = '', $to = '', ?array $options = null): RouteCollectionInterface
    {
        if (empty($from) || empty($to)) {
            throw new InvalidArgumentException('You must supply the parameters: from, to.');
        }
        foreach ($verbs as $verb) {
            $verb = strtolower($verb);
            $this->{$verb}($from, $to, $options);
        }
        return $this;
    }

    public function head(string $from, $to, ?array $options = null): RouteCollectionInterface
    {
        $this->create('head', $from, $to, $options);
        return $this;
    }

    public function options(string $from, $to, ?array $options = null): RouteCollectionInterface
    {
        $this->create('options', $from, $to, $options);
        return $this;
    }

    public function cli(string $from, $to, ?array $options = null): RouteCollectionInterface
    {
        $this->create('cli', $from, $to, $options);
        return $this;
    }

    public function view(string $from, string $view, ?array $options = null): RouteCollectionInterface
    {
        $to = static fn(...$data) => Services::renderer()->setData(['segments' => $data], 'raw')->render($view, $options);
        $this->create('get', $from, $to, $options);
        return $this;
    }

    public function environment(string $env, Closure $callback): RouteCollectionInterface
    {
        if ($env === ENVIRONMENT) {
            $callback($this);
        }
        return $this;
    }

    public function reverseRoute(string $search, ...$params)
    {
        foreach ($this->routes as $collection) {
            if (array_key_exists($search, $collection)) {
                return $this->buildReverseRoute(key($collection[$search]['route']), $params);
            }
        }
        $namespace = trim($this->defaultNamespace, '\\') . '\\';
        if (substr($search, 0, 1) !== '\\' && substr($search, 0, strlen($namespace)) !== $namespace) {
            $search = $namespace . $search;
        }
        foreach ($this->routes as $collection) {
            foreach ($collection as $route) {
                $from = key($route['route']);
                $to = $route['route'][$from];
                if (!is_string($to)) {
                    continue;
                }
                $to = ltrim($to, '\\');
                $search = ltrim($search, '\\');
                if (strpos($to, $search) !== 0) {
                    continue;
                }
                if (substr_count($to, '$') !== count($params)) {
                    continue;
                }
                return $this->buildReverseRoute($from, $params);
            }
        }
        return false;
    }

    protected function buildReverseRoute(string $from, array $params): string
    {
        $locale = null;
        preg_match_all('/\(([^)]+)\)/', $from, $matches);
        if (empty($matches[0])) {
            if (strpos($from, '{locale}') !== false) {
                $locale = $params[0] ?? null;
            }
            $from = $this->replaceLocale($from, $locale);
            return '/' . ltrim($from, '/');
        }
        $placeholderCount = count($matches[0]);
        if (count($params) > $placeholderCount) {
            $locale = $params[$placeholderCount];
        }
        foreach ($matches[0] as $index => $pattern) {
            if (!preg_match('#^' . $pattern . '$#u', $params[$index])) {
                throw RouterException::forInvalidParameterType();
            }
            $pos = strpos($from, $pattern);
            $from = substr_replace($from, $params[$index], $pos, strlen($pattern));
        }
        $from = $this->replaceLocale($from, $locale);
        return '/' . ltrim($from, '/');
    }

    private function replaceLocale(string $route, ?string $locale = null): string
    {
        if (strpos($route, '{locale}') === false) {
            return $route;
        }
        if ($locale !== null) {
            $config = config('App');
            if (!in_array($locale, $config->supportedLocales, true)) {
                $locale = null;
            }
        }
        if ($locale === null) {
            $locale = Services::request()->getLocale();
        }
        return strtr($route, ['{locale}' => $locale]);
    }

    public function isFiltered(string $search, ?string $verb = null): bool
    {
        $options = $this->loadRoutesOptions($verb);
        return isset($options[$search]['filter']);
    }

    protected function loadRoutesOptions(?string $verb = null): array
    {
        $verb = $verb ?: $this->getHTTPVerb();
        $options = $this->routesOptions[$verb] ?? [];
        if (isset($this->routesOptions['*'])) {
            foreach ($this->routesOptions['*'] as $key => $val) {
                if (isset($options[$key])) {
                    $extraOptions = array_diff_key($val, $options[$key]);
                    $options[$key] = array_merge($options[$key], $extraOptions);
                } else {
                    $options[$key] = $val;
                }
            }
        }
        return $options;
    }

    public function getHTTPVerb(): string
    {
        return $this->HTTPVerb;
    }

    public function setHTTPVerb(string $verb)
    {
        $this->HTTPVerb = $verb;
        return $this;
    }

    public function getFilterForRoute(string $search, ?string $verb = null): string
    {
        $options = $this->loadRoutesOptions($verb);
        return $options[$search]['filter'] ?? '';
    }

    public function getFiltersForRoute(string $search, ?string $verb = null): array
    {
        $options = $this->loadRoutesOptions($verb);
        if (!array_key_exists($search, $options)) {
            return [];
        }
        if (is_string($options[$search]['filter'])) {
            return [$options[$search]['filter']];
        }
        return $options[$search]['filter'] ?? [];
    }

    public function resetRoutes()
    {
        $this->routes = ['*' => []];
        foreach ($this->defaultHTTPMethods as $verb) {
            $this->routes[$verb] = [];
        }
        $this->prioritizeDetected = false;
        $this->didDiscover = false;
    }

    public function setPrioritize(bool $enabled = true)
    {
        $this->prioritize = $enabled;
        return $this;
    }

    public function getRegisteredControllers(?string $verb = '*'): array
    {
        $routes = [];
        if ($verb === '*') {
            $rawRoutes = [];
            foreach ($this->defaultHTTPMethods as $tmpVerb) {
                $rawRoutes = array_merge($rawRoutes, $this->routes[$tmpVerb]);
            }
            foreach ($rawRoutes as $route) {
                $key = key($route['route']);
                $handler = $route['route'][$key];
                $routes[$key] = $handler;
            }
        } else {
            $routes = $this->getRoutes($verb);
        }
        $controllers = [];
        foreach ($routes as $handler) {
            if (!is_string($handler)) {
                continue;
            }
            [$controller] = explode('::', $handler, 2);
            $controllers[] = $controller;
        }
        return array_unique($controllers);
    }

    public function getRoutes(?string $verb = null): array
    {
        if (empty($verb)) {
            $verb = $this->getHTTPVerb();
        }
        $this->discoverRoutes();
        $routes = [];
        if (isset($this->routes[$verb])) {
            $collection = $this->routes[$verb] + ($this->routes['*'] ?? []);
            foreach ($collection as $r) {
                $key = key($r['route']);
                $routes[$key] = $r['route'][$key];
            }
        }
        if ($this->prioritizeDetected && $this->prioritize && $routes !== []) {
            $order = [];
            foreach ($routes as $key => $value) {
                $key = $key === '/' ? $key : ltrim($key, '/ ');
                $priority = $this->getRoutesOptions($key, $verb)['priority'] ?? 0;
                $order[$priority][$key] = $value;
            }
            ksort($order);
            $routes = array_merge(...$order);
        }
        return $routes;
    }

    public function getRoutesOptions(?string $from = null, ?string $verb = null): array
    {
        $options = $this->loadRoutesOptions($verb);
        return $from ? $options[$from] ?? [] : $options;
    }

    public function useSupportedLocalesOnly(bool $useOnly): self
    {
        $this->useSupportedLocalesOnly = $useOnly;
        return $this;
    }

    public function shouldUseSupportedLocalesOnly(): bool
    {
        return $this->useSupportedLocalesOnly;
    }

    protected function localizeRoute(string $route): string
    {
        return strtr($route, ['{locale}' => Services::request()->getLocale()]);
    }

    protected function fillRouteParams(string $from, ?array $params = null): string
    {
        preg_match_all('/\(([^)]+)\)/', $from, $matches);
        if (empty($matches[0])) {
            return '/' . ltrim($from, '/');
        }
        foreach ($matches[0] as $index => $pattern) {
            if (!preg_match('#^' . $pattern . '$#u', $params[$index])) {
                throw RouterException::forInvalidParameterType();
            }
            $pos = strpos($from, $pattern);
            $from = substr_replace($from, $params[$index], $pos, strlen($pattern));
        }
        return '/' . ltrim($from, '/');
    }
}