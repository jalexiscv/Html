<?php

namespace MongoDB\Model;

use ArrayObject;
use JsonSerializable;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\Unserializable;
use ReturnTypeWillChange;
use function array_values;
use function MongoDB\recursive_copy;

class BSONArray extends ArrayObject implements JsonSerializable, Serializable, Unserializable
{
    public function __clone()
    {
        foreach ($this as $key => $value) {
            $this[$key] = recursive_copy($value);
        }
    }

    public static function __set_state(array $properties)
    {
        $array = new static();
        $array->exchangeArray($properties);
        return $array;
    }

    #[ReturnTypeWillChange] public function bsonSerialize()
    {
        return array_values($this->getArrayCopy());
    }

    #[ReturnTypeWillChange] public function bsonUnserialize(array $data)
    {
        self::__construct($data);
    }

    #[ReturnTypeWillChange] public function jsonSerialize()
    {
        return array_values($this->getArrayCopy());
    }
}