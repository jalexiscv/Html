<?php

namespace Higgs\Test\Mock;

use Closure;
use Higgs\Cache\CacheInterface;
use Higgs\Cache\Handlers\BaseHandler;
use Higgs\I18n\Time;
use PHPUnit\Framework\Assert;

class MockCache extends BaseHandler implements CacheInterface
{
    protected $cache = [];
    protected $expirations = [];
    protected $bypass = false;

    public function initialize()
    {
    }

    public function remember(string $key, int $ttl, Closure $callback)
    {
        $value = $this->get($key);
        if ($value !== null) {
            return $value;
        }
        $this->save($key, $value = $callback(), $ttl);
        return $value;
    }

    public function get(string $key)
    {
        $key = static::validateKey($key, $this->prefix);
        return array_key_exists($key, $this->cache) ? $this->cache[$key] : null;
    }

    public function save(string $key, $value, int $ttl = 60, bool $raw = false)
    {
        if ($this->bypass) {
            return false;
        }
        $key = static::validateKey($key, $this->prefix);
        $this->cache[$key] = $value;
        $this->expirations[$key] = $ttl > 0 ? Time::now()->getTimestamp() + $ttl : null;
        return true;
    }

    public function delete(string $key)
    {
        $key = static::validateKey($key, $this->prefix);
        if (!isset($this->cache[$key])) {
            return false;
        }
        unset($this->cache[$key], $this->expirations[$key]);
        return true;
    }

    public function deleteMatching(string $pattern)
    {
        $count = 0;
        foreach (array_keys($this->cache) as $key) {
            if (fnmatch($pattern, $key)) {
                $count++;
                unset($this->cache[$key], $this->expirations[$key]);
            }
        }
        return $count;
    }

    public function increment(string $key, int $offset = 1)
    {
        $key = static::validateKey($key, $this->prefix);
        $data = $this->cache[$key] ?: null;
        if (empty($data)) {
            $data = 0;
        } elseif (!is_int($data)) {
            return false;
        }
        return $this->save($key, $data + $offset);
    }

    public function decrement(string $key, int $offset = 1)
    {
        $key = static::validateKey($key, $this->prefix);
        $data = $this->cache[$key] ?: null;
        if (empty($data)) {
            $data = 0;
        } elseif (!is_int($data)) {
            return false;
        }
        return $this->save($key, $data - $offset);
    }

    public function getCacheInfo()
    {
        return array_keys($this->cache);
    }

    public function getMetaData(string $key)
    {
        if (!array_key_exists($key, $this->expirations)) {
            return null;
        }
        if (is_int($this->expirations[$key]) && $this->expirations[$key] > Time::now()->getTimestamp()) {
            return null;
        }
        return ['expire' => $this->expirations[$key]];
    }

    public function isSupported(): bool
    {
        return true;
    }

    public function bypass(bool $bypass = true)
    {
        $this->clean();
        $this->bypass = $bypass;
        return $this;
    }

    public function clean()
    {
        $this->cache = [];
        $this->expirations = [];
        return true;
    }

    public function assertHasValue(string $key, $value = null)
    {
        $item = $this->get($key);
        if (empty($item)) {
            $this->assertHas($key);
        }
        Assert::assertSame($value, $this->get($key), "The cached item `{$key}` does not equal match expectation. Found: " . print_r($value, true));
    }

    public function assertHas(string $key)
    {
        Assert::assertNotNull($this->get($key), "The cache does not have an item named: `{$key}`");
    }

    public function assertMissing(string $key)
    {
        Assert::assertArrayNotHasKey($key, $this->cache, "The cached item named `{$key}` exists.");
    }
}