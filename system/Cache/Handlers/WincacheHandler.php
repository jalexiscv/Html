<?php

namespace Higgs\Cache\Handlers;

use Higgs\I18n\Time;
use Config\Cache;
use Exception;

class WincacheHandler extends BaseHandler
{
    public function __construct(Cache $config)
    {
        $this->prefix = $config->prefix;
    }

    public function initialize()
    {
    }

    public function get(string $key)
    {
        $key = static::validateKey($key, $this->prefix);
        $success = false;
        $data = wincache_ucache_get($key, $success);
        return $success ? $data : null;
    }

    public function save(string $key, $value, int $ttl = 18000)
    {
        $key = static::validateKey($key, $this->prefix);
        return wincache_ucache_set($key, $value, $ttl);
    }

    public function delete(string $key)
    {
        $key = static::validateKey($key, $this->prefix);
        return wincache_ucache_delete($key);
    }

    public function deleteMatching(string $pattern)
    {
        throw new Exception('The deleteMatching method is not implemented for Wincache. You must select File, Redis or Predis handlers to use it.');
    }

    public function increment(string $key, int $offset = 1)
    {
        $key = static::validateKey($key, $this->prefix);
        return wincache_ucache_inc($key, $offset);
    }

    public function decrement(string $key, int $offset = 1)
    {
        $key = static::validateKey($key, $this->prefix);
        return wincache_ucache_dec($key, $offset);
    }

    public function clean()
    {
        return wincache_ucache_clear();
    }

    public function getCacheInfo()
    {
        return wincache_ucache_info(true);
    }

    public function getMetaData(string $key)
    {
        $key = static::validateKey($key, $this->prefix);
        if ($stored = wincache_ucache_info(false, $key)) {
            $age = $stored['ucache_entries'][1]['age_seconds'];
            $ttl = $stored['ucache_entries'][1]['ttl_seconds'];
            $hitcount = $stored['ucache_entries'][1]['hitcount'];
            return ['expire' => $ttl > 0 ? Time::now()->getTimestamp() + $ttl : null, 'hitcount' => $hitcount, 'age' => $age, 'ttl' => $ttl,];
        }
        return false;
    }

    public function isSupported(): bool
    {
        return extension_loaded('wincache') && ini_get('wincache.ucenabled');
    }
}