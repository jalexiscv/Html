<?php

namespace MongoDB\Model;

use ArrayAccess;
use MongoDB\Exception\BadMethodCallException;
use ReturnTypeWillChange;
use function array_key_exists;

class CollectionInfo implements ArrayAccess
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

    public function getCappedMax()
    {
        return isset($this->info['options']['max']) ? (integer)$this->info['options']['max'] : null;
    }

    public function getCappedSize()
    {
        return isset($this->info['options']['size']) ? (integer)$this->info['options']['size'] : null;
    }

    public function getIdIndex(): array
    {
        return (array)($this->info['idIndex'] ?? []);
    }

    public function getInfo(): array
    {
        return (array)($this->info['info'] ?? []);
    }

    public function getName()
    {
        return (string)$this->info['name'];
    }

    public function getOptions()
    {
        return (array)($this->info['options'] ?? []);
    }

    public function getType(): string
    {
        return (string)$this->info['type'];
    }

    public function isCapped()
    {
        return !empty($this->info['options']['capped']);
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