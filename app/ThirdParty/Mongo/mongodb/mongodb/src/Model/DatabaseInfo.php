<?php

namespace MongoDB\Model;

use ArrayAccess;
use MongoDB\Exception\BadMethodCallException;
use ReturnTypeWillChange;
use function array_key_exists;

class DatabaseInfo implements ArrayAccess
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

    public function getName()
    {
        return (string)$this->info['name'];
    }

    public function getSizeOnDisk()
    {
        return (integer)$this->info['sizeOnDisk'];
    }

    public function isEmpty()
    {
        return (boolean)$this->info['empty'];
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