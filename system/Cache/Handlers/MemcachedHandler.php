<?php

namespace Higgs\Cache\Handlers;

use Higgs\Exceptions\CriticalError;
use Higgs\I18n\Time;
use Config\Cache;
use Exception;
use Memcache;
use Memcached;

class MemcachedHandler extends BaseHandler
{
    protected $memcached;
    protected $config = ['host' => '127.0.0.1', 'port' => 11211, 'weight' => 1, 'raw' => false,];

    public function __construct(Cache $config)
    {
        $this->prefix = $config->prefix;
        $this->config = array_merge($this->config, $config->memcached);
    }

    public function __destruct()
    {
        if ($this->memcached instanceof Memcached) {
            $this->memcached->quit();
        } elseif ($this->memcached instanceof Memcache) {
            $this->memcached->close();
        }
    }

    public function initialize()
    {
        try {
            if (class_exists(Memcached::class)) {
                $this->memcached = new Memcached();
                if ($this->config['raw']) {
                    $this->memcached->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
                }
                $this->memcached->addServer($this->config['host'], $this->config['port'], $this->config['weight']);
                $stats = $this->memcached->getStats();
                if (!isset($stats[$this->config['host'] . ':' . $this->config['port']])) {
                    throw new CriticalError('Cache: Memcached connection failed.');
                }
            } elseif (class_exists(Memcache::class)) {
                $this->memcached = new Memcache();
                $canConnect = $this->memcached->connect($this->config['host'], $this->config['port']);
                if ($canConnect === false) {
                    throw new CriticalError('Cache: Memcache connection failed.');
                }
                $this->memcached->addServer($this->config['host'], $this->config['port'], true, $this->config['weight']);
            } else {
                throw new CriticalError('Cache: Not support Memcache(d) extension.');
            }
        } catch (Exception $e) {
            throw new CriticalError('Cache: Memcache(d) connection refused (' . $e->getMessage() . ').');
        }
    }

    public function save(string $key, $value, int $ttl = 18000)
    {
        $key = static::validateKey($key, $this->prefix);
        if (!$this->config['raw']) {
            $value = [$value, Time::now()->getTimestamp(), $ttl,];
        }
        if ($this->memcached instanceof Memcached) {
            return $this->memcached->set($key, $value, $ttl);
        }
        if ($this->memcached instanceof Memcache) {
            return $this->memcached->set($key, $value, 0, $ttl);
        }
        return false;
    }

    public function delete(string $key)
    {
        $key = static::validateKey($key, $this->prefix);
        return $this->memcached->delete($key);
    }

    public function deleteMatching(string $pattern)
    {
        throw new Exception('The deleteMatching method is not implemented for Memcached. You must select File, Redis or Predis handlers to use it.');
    }

    public function increment(string $key, int $offset = 1)
    {
        if (!$this->config['raw']) {
            return false;
        }
        $key = static::validateKey($key, $this->prefix);
        return $this->memcached->increment($key, $offset, $offset, 18000);
    }

    public function decrement(string $key, int $offset = 1)
    {
        if (!$this->config['raw']) {
            return false;
        }
        $key = static::validateKey($key, $this->prefix);
        return $this->memcached->decrement($key, $offset, $offset, 18000);
    }

    public function clean()
    {
        return $this->memcached->flush();
    }

    public function getCacheInfo()
    {
        return $this->memcached->getStats();
    }

    public function getMetaData(string $key)
    {
        $key = static::validateKey($key, $this->prefix);
        $stored = $this->memcached->get($key);
        if (!is_array($stored) || count($stored) !== 3) {
            return false;
        }
        [$data, $time, $limit] = $stored;
        return ['expire' => $limit > 0 ? $time + $limit : null, 'mtime' => $time, 'data' => $data,];
    }

    public function get(string $key)
    {
        $key = static::validateKey($key, $this->prefix);
        if ($this->memcached instanceof Memcached) {
            $data = $this->memcached->get($key);
            if ($this->memcached->getResultCode() === Memcached::RES_NOTFOUND) {
                return null;
            }
        } elseif ($this->memcached instanceof Memcache) {
            $flags = false;
            $data = $this->memcached->get($key, $flags);
            if ($flags === false) {
                return null;
            }
        }
        return is_array($data) ? $data[0] : $data;
    }

    public function isSupported(): bool
    {
        return extension_loaded('memcached') || extension_loaded('memcache');
    }
}