<?php

namespace Higgs\View;

use Higgs\Cache\CacheInterface;
use Higgs\Config\Factories;
use Higgs\View\Cells\Cell as BaseCell;
use Higgs\View\Exceptions\ViewException;
use Config\Services;
use ReflectionException;
use ReflectionMethod;

class Cell
{
    protected $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function render(string $library, $params = null, int $ttl = 0, ?string $cacheName = null): string
    {
        [$instance, $method] = $this->determineClass($library);
        $class = is_object($instance) ? get_class($instance) : null;
        $cacheName = !empty($cacheName) ? $cacheName : str_replace(['\\', '/'], '', $class) . $method . md5(serialize($params));
        if (!empty($this->cache) && $output = $this->cache->get($cacheName)) {
            return $output;
        }
        if (method_exists($instance, 'initController')) {
            $instance->initController(Services::request(), Services::response(), Services::logger());
        }
        if (!method_exists($instance, $method)) {
            throw ViewException::forInvalidCellMethod($class, $method);
        }
        $params = $this->prepareParams($params);
        $output = $instance instanceof BaseCell ? $this->renderCell($instance, $method, $params) : $this->renderSimpleClass($instance, $method, $params, $class);
        if (!empty($this->cache) && $ttl !== 0) {
            $this->cache->save($cacheName, $output, $ttl);
        }
        return $output;
    }

    protected function determineClass(string $library): array
    {
        $library = str_replace('::', ':', $library);
        if (strpos($library, ':') === false) {
            $library .= ':render';
        }
        [$class, $method] = explode(':', $library);
        if (empty($class)) {
            throw ViewException::forNoCellClass();
        }
        $class = Factories::cells($class);
        if (!is_object($class)) {
            throw ViewException::forInvalidCellClass($class);
        }
        if (empty($method)) {
            $method = 'index';
        }
        return [$class, $method,];
    }

    public function prepareParams($params)
    {
        if (empty($params) || (!is_string($params) && !is_array($params))) {
            return [];
        }
        if (is_string($params)) {
            $newParams = [];
            $separator = ' ';
            if (strpos($params, ',') !== false) {
                $separator = ',';
            }
            $params = explode($separator, $params);
            unset($separator);
            foreach ($params as $p) {
                if (!empty($p)) {
                    [$key, $val] = explode('=', $p);
                    $newParams[trim($key)] = trim($val, ', ');
                }
            }
            $params = $newParams;
            unset($newParams);
        }
        if ($params === []) {
            return [];
        }
        return $params;
    }

    final protected function renderCell(BaseCell $instance, string $method, array $params): string
    {
        $publicProperties = $instance->getPublicProperties();
        $privateProperties = array_column($instance->getNonPublicProperties(), 'name');
        $publicParams = array_intersect_key($params, $publicProperties);
        foreach ($params as $key => $value) {
            $getter = 'get' . ucfirst($key) . 'Property';
            if (in_array($key, $privateProperties, true) && method_exists($instance, $getter)) {
                $publicParams[$key] = $value;
            }
        }
        $instance = $instance->fill($publicParams);
        if (method_exists($instance, 'mount')) {
            $mountParams = $this->getMethodParams($instance, 'mount', $params);
            $instance->mount(...$mountParams);
        }
        return $instance->{$method}();
    }

    private function getMethodParams(BaseCell $instance, string $method, array $params)
    {
        $mountParams = [];
        try {
            $reflectionMethod = new ReflectionMethod($instance, $method);
            $reflectionParams = $reflectionMethod->getParameters();
            foreach ($reflectionParams as $reflectionParam) {
                $paramName = $reflectionParam->getName();
                if (array_key_exists($paramName, $params)) {
                    $mountParams[] = $params[$paramName];
                }
            }
        } catch (ReflectionException $e) {
        }
        return $mountParams;
    }

    final protected function renderSimpleClass($instance, string $method, array $params, string $class): string
    {
        $refMethod = new ReflectionMethod($instance, $method);
        $paramCount = $refMethod->getNumberOfParameters();
        $refParams = $refMethod->getParameters();
        if ($paramCount === 0) {
            if (!empty($params)) {
                throw ViewException::forMissingCellParameters($class, $method);
            }
            $output = $instance->{$method}();
        } elseif (($paramCount === 1) && ((!array_key_exists($refParams[0]->name, $params)) || (array_key_exists($refParams[0]->name, $params) && count($params) !== 1))) {
            $output = $instance->{$method}($params);
        } else {
            $fireArgs = [];
            $methodParams = [];
            foreach ($refParams as $arg) {
                $methodParams[$arg->name] = true;
                if (array_key_exists($arg->name, $params)) {
                    $fireArgs[$arg->name] = $params[$arg->name];
                }
            }
            foreach (array_keys($params) as $key) {
                if (!isset($methodParams[$key])) {
                    throw ViewException::forInvalidCellParameter($key);
                }
            }
            $output = $instance->{$method}(...array_values($fireArgs));
        }
        return $output;
    }
}