<?php

namespace MongoDB\Model;

use Closure;
use Iterator;
use IteratorIterator;
use ReturnTypeWillChange;
use Traversable;

class CallbackIterator implements Iterator
{
    private $callback;
    private $iterator;

    public function __construct(Traversable $traversable, Closure $callback)
    {
        $this->iterator = $traversable instanceof Iterator ? $traversable : new IteratorIterator($traversable);
        $this->callback = $callback;
    }

    #[ReturnTypeWillChange] public function current()
    {
        return ($this->callback)($this->iterator->current());
    }

    #[ReturnTypeWillChange] public function key()
    {
        return $this->iterator->key();
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    public function rewind(): void
    {
        $this->iterator->rewind();
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }
}