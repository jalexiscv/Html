<?php

namespace MongoDB\Model;

use ArrayAccess;
use MongoDB\Exception\BadMethodCallException;
use ReturnTypeWillChange;
use function array_key_exists;
use function array_search;

class IndexInfo implements ArrayAccess
{
    private $info;

    public function __construct(array $info)
    {
        $this->info = $info;
    }

    public function __debugInfo()
    {
        return $this->info;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getKey()
    {
        return (array)$this->info['key'];
    }

    public function getName()
    {
        return (string)$this->info['name'];
    }

    public function getNamespace()
    {
        return (string)$this->info['ns'];
    }

    public function getVersion()
    {
        return (integer)$this->info['v'];
    }

    public function is2dSphere()
    {
        return array_search('2dsphere', $this->getKey(), true) !== false;
    }

    public function isGeoHaystack()
    {
        return array_search('geoHaystack', $this->getKey(), true) !== false;
    }

    public function isSparse()
    {
        return !empty($this->info['sparse']);
    }

    public function isText()
    {
        return array_search('text', $this->getKey(), true) !== false;
    }

    public function isTtl()
    {
        return array_key_exists('expireAfterSeconds', $this->info);
    }

    public function isUnique()
    {
        return !empty($this->info['unique']);
    }

    #[ReturnTypeWillChange] public function offsetExists($key)
    {
        return array_key_exists($key, $this->info);
    }

    #[ReturnTypeWillChange] public function offsetGet($key)
    {
        return $this->info[$key];
    }

    #[ReturnTypeWillChange] public function offsetSet($key, $value)
    {
        throw BadMethodCallException::classIsImmutable(self::class);
    }

    #[ReturnTypeWillChange] public function offsetUnset($key)
    {
        throw BadMethodCallException::classIsImmutable(self::class);
    }
}