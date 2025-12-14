<?php

namespace Higgs\Cache\Handlers;

use Higgs\Exceptions\CriticalError;
use Higgs\I18n\Time;
use Config\Cache;
use Exception;
use Predis\Client;
use Predis\Collection\Iterator\Keyspace;

class PredisHandler extends BaseHandler
{
    protected $config = ['scheme' => 'tcp', 'host' => '127.0.0.1', 'password' => null, 'port' => 6379, 'timeout' => 0,];
    protected $redis;

    public function __construct(Cache $config)
    {
        $this->prefix = $config->prefix;
        if (isset($config->redis)) {
            $this->config = array_merge($this->config, $config->redis);
        }
    }

    public function initialize()
    {
        try {
            $this->redis = new Client($this->config, ['prefix' => $this->prefix]);
            $this->redis->time();
        } catch (Exception $e) {
            throw new CriticalError('Cache: Predis connection refused (' . $e->getMessage() . ').');
        }
    }

    public function get(string $key)
    {
        $key = static::validateKey($key);
        $data = array_combine(['__ci_type', '__ci_value'], $this->redis->hmget($key, ['__ci_type', '__ci_value']));
        if (!isset($data['__ci_type'], $data['__ci_value']) || $data['__ci_value'] === false) {
            return null;
        }
        switch ($data['__ci_type']) {
            case 'array':
            case 'object':
                return unserialize($data['__ci_value']);
            case 'boolean':
            case 'integer':
            case 'double':
            case 'string':
            case 'NULL':
                return settype($data['__ci_value'], $data['__ci_type']) ? $data['__ci_value'] : null;
            case 'resource':
            default:
                return null;
        }
    }

    public function save(string $key, $value, int $ttl = 18000)
    {
        $key = static::validateKey($key);
        switch ($dataType = gettype($value)) {
            case 'array':
            case 'object':
                $value = serialize($value);
                break;
            case 'boolean':
            case 'integer':
            case 'double':
            case 'string':
            case 'NULL':
                break;
            case 'resource':
            default:
                return false;
        }
        if (!$this->redis->hmset($key, ['__ci_type' => $dataType, '__ci_value' => $value])) {
            return false;
        }
        if ($ttl) {
            $this->redis->expireat($key, Time::now()->getTimestamp() + $ttl);
        }
        return true;
    }

    public function delete(string $key)
    {
        $key = static::validateKey($key);
        return $this->redis->del($key) === 1;
    }

    public function deleteMatching(string $pattern)
    {
        $matchedKeys = [];
        foreach (new Keyspace($this->redis, $pattern) as $key) {
            $matchedKeys[] = $key;
        }
        return $this->redis->del($matchedKeys);
    }

    public function increment(string $key, int $offset = 1)
    {
        $key = static::validateKey($key);
        return $this->redis->hincrby($key, 'data', $offset);
    }

    public function decrement(string $key, int $offset = 1)
    {
        $key = static::validateKey($key);
        return $this->redis->hincrby($key, 'data', -$offset);
    }

    public function clean()
    {
        return $this->redis->flushdb()->getPayload() === 'OK';
    }

    public function getCacheInfo()
    {
        return $this->redis->info();
    }

    public function getMetaData(string $key)
    {
        $key = static::validateKey($key);
        $data = array_combine(['__ci_value'], $this->redis->hmget($key, ['__ci_value']));
        if (isset($data['__ci_value']) && $data['__ci_value'] !== false) {
            $time = Time::now()->getTimestamp();
            $ttl = $this->redis->ttl($key);
            return ['expire' => $ttl > 0 ? $time + $ttl : null, 'mtime' => $time, 'data' => $data['__ci_value'],];
        }
        return null;
    }

    public function isSupported(): bool
    {
        return class_exists(Client::class);
    }
}