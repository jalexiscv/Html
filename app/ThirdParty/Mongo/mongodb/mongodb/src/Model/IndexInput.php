<?php

namespace MongoDB\Model;

use MongoDB\BSON\Serializable;
use MongoDB\Exception\InvalidArgumentException;
use function is_array;
use function is_float;
use function is_int;
use function is_object;
use function is_string;
use function MongoDB\generate_index_name;
use function sprintf;

class IndexInput implements Serializable
{
    private $index;

    public function __construct(array $index)
    {
        if (!isset($index['key'])) {
            throw new InvalidArgumentException('Required "key" document is missing from index specification');
        }
        if (!is_array($index['key']) && !is_object($index['key'])) {
            throw InvalidArgumentException::invalidType('"key" option', $index['key'], 'array or object');
        }
        foreach ($index['key'] as $fieldName => $order) {
            if (!is_int($order) && !is_float($order) && !is_string($order)) {
                throw InvalidArgumentException::invalidType(sprintf('order value for "%s" field within "key" option', $fieldName), $order, 'numeric or string');
            }
        }
        if (!isset($index['name'])) {
            $index['name'] = generate_index_name($index['key']);
        }
        if (!is_string($index['name'])) {
            throw InvalidArgumentException::invalidType('"name" option', $index['name'], 'string');
        }
        $this->index = $index;
    }

    public function __toString(): string
    {
        return $this->index['name'];
    }

    public function bsonSerialize(): array
    {
        return $this->index;
    }
}