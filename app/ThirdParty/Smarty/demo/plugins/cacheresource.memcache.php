<?php

class Smarty_CacheResource_Memcache extends Smarty_CacheResource_KeyValueStore
{
    protected $memcache = null;

    public function __construct()
    {
        if (class_exists('Memcached')) {
            $this->memcache = new Memcached();
        } else {
            $this->memcache = new Memcache();
        }
        $this->memcache->addServer('127.0.0.1', 11211);
    }

    protected function read(array $keys)
    {
        $res = array();
        foreach ($keys as $key) {
            $k = sha1($key);
            $res[$key] = $this->memcache->get($k);
        }
        return $res;
    }

    protected function write(array $keys, $expire = null)
    {
        foreach ($keys as $k => $v) {
            $k = sha1($k);
            if (class_exists('Memcached')) {
                $this->memcache->set($k, $v, $expire);
            } else {
                $this->memcache->set($k, $v, 0, $expire);
            }
        }
        return true;
    }

    protected function delete(array $keys)
    {
        foreach ($keys as $k) {
            $k = sha1($k);
            $this->memcache->delete($k);
        }
        return true;
    }

    protected function purge()
    {
        return $this->memcache->flush();
    }
}