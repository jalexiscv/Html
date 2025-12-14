<?php

namespace Higgs\Cache\Handlers;

use Closure;

class DummyHandler extends BaseHandler
{
    public function initialize()
    {
    }

    public function get(string $key)
    {
        return null;
    }

    public function remember(string $key, int $ttl, Closure $callback)
    {
        return null;
    }

    public function save(string $key, $value, int $ttl = 18000)
    {
        return true;
    }

    public function delete(string $key)
    {
        return true;
    }

    public function deleteMatching(string $pattern)
    {
        return 0;
    }

    public function increment(string $key, int $offset = 1)
    {
        return true;
    }

    public function decrement(string $key, int $offset = 1)
    {
        return true;
    }

    public function clean()
    {
        return true;
    }

    public function getCacheInfo()
    {
        return null;
    }

    public function getMetaData(string $key)
    {
        return null;
    }

    public function isSupported(): bool
    {
        return true;
    }
}