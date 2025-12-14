<?php

namespace MongoDB\Model;

use ArrayObject;
use JsonSerializable;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\Unserializable;
use ReturnTypeWillChange;
use function MongoDB\recursive_copy;

class BSONDocument extends ArrayObject implements JsonSerializable, Serializable, Unserializable
{
    public function __clone()
    {
        foreach ($this as $key => $value) {
            $this[$key] = recursive_copy($value);
        }
    }

    public function __construct(array $input = [], int $flags = ArrayObject::ARRAY_AS_PROPS, string $iteratorClass = 'ArrayIterator')
    {
        parent::__construct($input, $flags, $iteratorClass);
    }

    public static function __set_state(array $properties)
    {
        $document = new static();
        $document->exchangeArray($properties);
        return $document;
    }

    #[ReturnTypeWillChange] public function bsonSerialize()
    {
        return (object)$this->getArrayCopy();
    }

    #[ReturnTypeWillChange] public function bsonUnserialize(array $data)
    {
        parent::__construct($data, ArrayObject::ARRAY_AS_PROPS);
    }

    #[ReturnTypeWillChange] public function jsonSerialize()
    {
        return (object)$this->getArrayCopy();
    }
}