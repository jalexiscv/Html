<?php

namespace Higgs\Filters;

use Higgs\Filters\Exceptions\FilterException;
use Higgs\HTTP\RequestInterface;
use Higgs\HTTP\ResponseInterface;
use Config\Filters as FiltersConfig;
use Config\Modules;
use Config\Services;

class Filters
{
    protected $config;
    protected $request;
    protected $response;
    protected $modules;
    protected $initialized = false;
    protected $filters = ['before' => [], 'after' => [],];
    protected $filtersClass = ['before' => [], 'after' => [],];
    protected $arguments = [];
    protected $argumentsClass = [];

    public function __construct($config, RequestInterface $request, ResponseInterface $response, ?Modules $modules = null)
    {
        $this->config = $config;
        $this->request = &$request;
        $this->setResponse($response);
        $this->modules = $modules ?? config('Modules');
        if ($this->modules->shouldDiscover('filters')) {
            $this->discoverFilters();
        }
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    private function discoverFilters()
    {
        $locator = Services::locator();
        $filters = $this->config;
        $files = $locator->search('Config/Filters.php');
        foreach ($files as $file) {
            $className = $locator->getClassname($file);
            if ($className === FiltersConfig::class) {
                continue;
            }
            include $file;
        }
    }

    public function run(string $uri, string $position = 'before')
    {
        $this->initialize(strtolower($uri));
        foreach ($this->filtersClass[$position] as $className) {
            $class = new $className();
            if (!$class instanceof FilterInterface) {
                throw FilterException::forIncorrectInterface(get_class($class));
            }
            if ($position === 'before') {
                $result = $class->before($this->request, $this->argumentsClass[$className] ?? null);
                if ($result instanceof RequestInterface) {
                    $this->request = $result;
                    continue;
                }
                if ($result instanceof ResponseInterface) {
                    return $result;
                }
                if (empty($result)) {
                    continue;
                }
                return $result;
            }
            if ($position === 'after') {
                $result = $class->after($this->request, $this->response, $this->argumentsClass[$className] ?? null);
                if ($result instanceof ResponseInterface) {
                    $this->response = $result;
                    continue;
                }
            }
        }
        return $position === 'before' ? $this->request : $this->response;
    }

    public function initialize(?string $uri = null)
    {
        if ($this->initialized === true) {
            return $this;
        }
        $this->processGlobals($uri);
        $this->processMethods();
        $this->processFilters($uri);
        if (in_array('toolbar', $this->filters['after'], true) && ($count = count($this->filters['after'])) > 1 && $this->filters['after'][$count - 1] !== 'toolbar') {
            array_splice($this->filters['after'], array_search('toolbar', $this->filters['after'], true), 1);
            $this->filters['after'][] = 'toolbar';
        }
        $this->processAliasesToClass('before');
        $this->processAliasesToClass('after');
        $this->initialized = true;
        return $this;
    }

    protected function processGlobals(?string $uri = null)
    {
        if (!isset($this->config->globals) || !is_array($this->config->globals)) {
            return;
        }
        $uri = strtolower(trim($uri ?? '', '/ '));
        $sets = ['before', 'after'];
        foreach ($sets as $set) {
            if (isset($this->config->globals[$set])) {
                foreach ($this->config->globals[$set] as $alias => $rules) {
                    $keep = true;
                    if (is_array($rules)) {
                        if (isset($rules['except'])) {
                            $check = $rules['except'];
                            if ($this->pathApplies($uri, $check)) {
                                $keep = false;
                            }
                        }
                    } else {
                        $alias = $rules;
                    }
                    if ($keep) {
                        $this->filters[$set][] = $alias;
                    }
                }
            }
        }
    }

    private function pathApplies(string $uri, $paths)
    {
        if (empty($paths)) {
            return true;
        }
        if (is_string($paths)) {
            $paths = [$paths];
        }
        foreach ($paths as $path) {
            $path = str_replace('/', '\/', trim($path, '/ '));
            $path = strtolower(str_replace('*', '.*', $path));
            if (preg_match('#^' . $path . '$#', $uri, $match) === 1) {
                return true;
            }
        }
        return false;
    }

    protected function processMethods()
    {
        if (!isset($this->config->methods) || !is_array($this->config->methods)) {
            return;
        }
        $method = strtolower($this->request->getMethod()) ?? 'cli';
        if (array_key_exists($method, $this->config->methods)) {
            $this->filters['before'] = array_merge($this->filters['before'], $this->config->methods[$method]);
        }
    }

    protected function processFilters(?string $uri = null)
    {
        if (!isset($this->config->filters) || !$this->config->filters) {
            return;
        }
        $uri = strtolower(trim($uri, '/ '));
        foreach ($this->config->filters as $alias => $settings) {
            if (isset($settings['before'])) {
                $path = $settings['before'];
                if ($this->pathApplies($uri, $path)) {
                    $this->filters['before'][] = $alias;
                }
            }
            if (isset($settings['after'])) {
                $path = $settings['after'];
                if ($this->pathApplies($uri, $path)) {
                    $this->filters['after'][] = $alias;
                }
            }
        }
    }

    protected function processAliasesToClass(string $position)
    {
        foreach ($this->filters[$position] as $alias => $rules) {
            if (is_numeric($alias) && is_string($rules)) {
                $alias = $rules;
            }
            if (!array_key_exists($alias, $this->config->aliases)) {
                throw FilterException::forNoAlias($alias);
            }
            if (is_array($this->config->aliases[$alias])) {
                $this->filtersClass[$position] = array_merge($this->filtersClass[$position], $this->config->aliases[$alias]);
            } else {
                $this->filtersClass[$position][] = $this->config->aliases[$alias];
            }
        }
        $this->filtersClass[$position] = array_values(array_unique($this->filtersClass[$position]));
    }

    public function reset(): self
    {
        $this->initialized = false;
        $this->arguments = $this->argumentsClass = [];
        $this->filters = $this->filtersClass = ['before' => [], 'after' => [],];
        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getFiltersClass(): array
    {
        return $this->filtersClass;
    }

    public function addFilter(string $class, ?string $alias = null, string $when = 'before', string $section = 'globals')
    {
        $alias ??= md5($class);
        if (!isset($this->config->{$section})) {
            $this->config->{$section} = [];
        }
        if (!isset($this->config->{$section}[$when])) {
            $this->config->{$section}[$when] = [];
        }
        $this->config->aliases[$alias] = $class;
        $this->config->{$section}[$when][] = $alias;
        return $this;
    }

    public function enableFilters(array $names, string $when = 'before')
    {
        foreach ($names as $filter) {
            $this->enableFilter($filter, $when);
        }
        return $this;
    }

    public function enableFilter(string $name, string $when = 'before')
    {
        if (strpos($name, ':') !== false) {
            [$name, $params] = explode(':', $name);
            $params = explode(',', $params);
            array_walk($params, static function (&$item) {
                $item = trim($item);
            });
            $this->arguments[$name] = $params;
        }
        if (class_exists($name)) {
            $this->config->aliases[$name] = $name;
        } elseif (!array_key_exists($name, $this->config->aliases)) {
            throw FilterException::forNoAlias($name);
        }
        $classNames = (array)$this->config->aliases[$name];
        foreach ($classNames as $className) {
            $this->argumentsClass[$className] = $this->arguments[$name] ?? null;
        }
        if (!isset($this->filters[$when][$name])) {
            $this->filters[$when][] = $name;
            $this->filtersClass[$when] = array_merge($this->filtersClass[$when], $classNames);
        }
        return $this;
    }

    public function getArguments(?string $key = null)
    {
        return $key === null ? $this->arguments : $this->arguments[$key];
    }
}