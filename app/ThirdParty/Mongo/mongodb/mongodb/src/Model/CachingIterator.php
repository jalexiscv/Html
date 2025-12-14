<?php

namespace MongoDB\Model;

use Countable;
use Iterator;
use IteratorIterator;
use ReturnTypeWillChange;
use Traversable;
use function count;
use function current;
use function next;
use function reset;

class CachingIterator implements Countable, Iterator
{
    private const FIELD_KEY = 0;
    private const FIELD_VALUE = 1;
    private $items = [];
    private $iterator;
    private $iteratorAdvanced = false;
    private $iteratorExhausted = false;

    public function __construct(Traversable $traversable)
    {
        $this->iterator = $traversable instanceof Iterator ? $traversable : new IteratorIterator($traversable);
        $this->iterator->rewind();
        $this->storeCurrentItem();
    }

    public function count(): int
    {
        $this->exhaustIterator();
        return count($this->items);
    }

    #[ReturnTypeWillChange] public function current()
    {
        $currentItem = current($this->items);
        return $currentItem !== false ? $currentItem[self::FIELD_VALUE] : false;
    }

    #[ReturnTypeWillChange] public function key()
    {
        $currentItem = current($this->items);
        return $currentItem !== false ? $currentItem[self::FIELD_KEY] : null;
    }

    public function next(): void
    {
        if (!$this->iteratorExhausted) {
            $this->iteratorAdvanced = true;
            $this->iterator->next();
            $this->storeCurrentItem();
            $this->iteratorExhausted = !$this->iterator->valid();
        }
        next($this->items);
    }

    public function rewind(): void
    {
        if ($this->iteratorAdvanced) {
            $this->exhaustIterator();
        }
        reset($this->items);
    }

    public function valid(): bool
    {
        return $this->key() !== null;
    }

    private function exhaustIterator(): void
    {
        while (!$this->iteratorExhausted) {
            $this->next();
        }
    }

    private function storeCurrentItem(): void
    {
        if (!$this->iterator->valid()) {
            return;
        }
        $this->items[] = [self::FIELD_KEY => $this->iterator->key(), self::FIELD_VALUE => $this->iterator->current(),];
    }
}