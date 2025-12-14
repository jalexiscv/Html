<?php

namespace Twilio;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

abstract class Options implements IteratorAggregate
{
    protected $options = [];

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->options);
    }
}