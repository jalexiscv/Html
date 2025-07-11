<?php

namespace App;

class CacheHandler
{
    private $cacheDir;

    public function __construct($cacheDir = 'cache/')
    {
        $this->cacheDir = $cacheDir;
    }

    public function buscaCache($key)
    {
        $filename = $this->geraCacheKey($key);
        if (file_exists($filename)) {
            return json_decode(file_get_contents($filename), true);
        }
        return false;
    }

    private function geraCacheKey($key)
    {
        return $this->cacheDir . md5($key) . '.cache';
    }

    public function salvaNoCache($key, $data)
    {
        $filename = $this->geraCacheKey($key);
        file_put_contents($filename, json_encode($data));
    }
}
