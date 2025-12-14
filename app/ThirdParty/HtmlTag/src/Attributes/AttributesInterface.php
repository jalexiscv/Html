<?php

namespace drupol\htmltag\Attributes;

use ArrayAccess;
use ArrayIterator;
use Countable;
use drupol\htmltag\PreprocessableInterface;
use drupol\htmltag\RenderableInterface;
use drupol\htmltag\StringableInterface;
use IteratorAggregate;
use Serializable;
use Traversable;

interface AttributesInterface extends ArrayAccess, Countable, IteratorAggregate, Serializable, PreprocessableInterface, RenderableInterface, StringableInterface
{
    public function __toString();

    public function append($key, ...$values);

    public function contains($key, ...$values);

    public function delete(...$keys);

    public function exists($key, ...$values);

    public function getStorage();

    public function getValuesAsArray();

    public function import($data);

    public function merge(array ...$dataset);

    public function remove($key, ...$values);

    public function replace($key, $value, ...$replacements);

    public function set($key, ...$values);

    public function without(...$keys);
}