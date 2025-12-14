<?php

namespace MongoDB\Model;

use Iterator;
use MongoDB\Exception\InvalidArgumentException;
use MongoDB\Exception\UnexpectedValueException;
use ReturnTypeWillChange;
use function is_array;
use function MongoDB\BSON\toPHP;
use function sprintf;
use function strlen;
use function substr;
use function unpack;

class BSONIterator implements Iterator
{
    private static $bsonSize = 4;
    private $buffer;
    private $bufferLength;
    private $current;
    private $key = 0;
    private $position = 0;
    private $options;

    public function __construct(string $data, array $options = [])
    {
        if (isset($options['typeMap']) && !is_array($options['typeMap'])) {
            throw InvalidArgumentException::invalidType('"typeMap" option', $options['typeMap'], 'array');
        }
        if (!isset($options['typeMap'])) {
            $options['typeMap'] = [];
        }
        $this->buffer = $data;
        $this->bufferLength = strlen($data);
        $this->options = $options;
    }

    #[ReturnTypeWillChange] public function current()
    {
        return $this->current;
    }

    #[ReturnTypeWillChange] public function key()
    {
        return $this->key;
    }

    #[ReturnTypeWillChange] public function next()
    {
        $this->key++;
        $this->current = null;
        $this->advance();
    }

    #[ReturnTypeWillChange] public function rewind()
    {
        $this->key = 0;
        $this->position = 0;
        $this->current = null;
        $this->advance();
    }

    #[ReturnTypeWillChange] public function valid(): bool
    {
        return $this->current !== null;
    }

    private function advance(): void
    {
        if ($this->position === $this->bufferLength) {
            return;
        }
        if ($this->bufferLength - $this->position < self::$bsonSize) {
            throw new UnexpectedValueException(sprintf('Expected at least %d bytes; %d remaining', self::$bsonSize, $this->bufferLength - $this->position));
        }
        [, $documentLength] = unpack('V', substr($this->buffer, $this->position, self::$bsonSize));
        if ($this->bufferLength - $this->position < $documentLength) {
            throw new UnexpectedValueException(sprintf('Expected %d bytes; %d remaining', $documentLength, $this->bufferLength - $this->position));
        }
        $this->current = toPHP(substr($this->buffer, $this->position, $documentLength), $this->options['typeMap']);
        $this->position += $documentLength;
    }
}