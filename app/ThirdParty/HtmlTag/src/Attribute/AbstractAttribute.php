<?php

namespace drupol\htmltag\Attribute;

use BadMethodCallException;
use drupol\htmltag\AbstractBaseHtmlTagObject;
use InvalidArgumentException;
use function array_diff;
use function array_filter;
use function array_map;
use function count;
use function htmlspecialchars;
use function implode;
use function in_array;
use function preg_match;
use function serialize;
use function unserialize;
use const ENT_QUOTES;
use const ENT_SUBSTITUTE;

abstract class AbstractAttribute extends AbstractBaseHtmlTagObject implements AttributeInterface
{
    private $name;
    private $values;

    public function __construct($name, ...$values)
    {
        if (1 === preg_match('/[\t\n\f \/>"\'=]+/', $name)) {
            throw new InvalidArgumentException('Attribute name is not valid.');
        }
        $this->name = $name;
        $this->values = $values;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function render()
    {
        return null === ($values = $this->getValuesAsString()) ? $this->name : $this->name . '="' . $values . '"';
    }

    public function getValuesAsString()
    {
        return ($values = $this->getValuesAsArray()) === [] ? null : (string)$this->escape(implode(' ', array_filter($values, '\strlen')));
    }

    public function getValuesAsArray()
    {
        return $this->ensureStrings($this->preprocess($this->ensureFlatArray($this->values), ['name' => $this->name]));
    }

    public function preprocess(array $values, array $context = [])
    {
        return $values;
    }

    public function escape($value)
    {
        return null === $value ? $value : htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE);
    }

    public function alter(callable ...$closures)
    {
        foreach ($closures as $closure) {
            $this->values = $closure($this->ensureFlatArray($this->values), $this->name);
        }
        return $this;
    }

    public function delete()
    {
        $this->name = '';
        $this->values = [];
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isBoolean()
    {
        return $this->getValuesAsArray() === [];
    }

    public function offsetExists($offset)
    {
        return $this->contains($offset);
    }

    public function contains(...$substring)
    {
        $values = $this->ensureFlatArray($this->values);
        return !in_array(false, array_map(static function ($substring_item) use ($values) {
            return in_array($substring_item, $values, true);
        }, $this->ensureFlatArray($substring)), true);
    }

    public function offsetGet($offset)
    {
        throw new BadMethodCallException('Unsupported method.');
    }

    public function offsetSet($offset, $value)
    {
        $this->append($value);
    }

    public function append(...$value)
    {
        $this->values[] = $value;
        return $this;
    }

    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    public function remove(...$value)
    {
        return $this->set(array_diff($this->ensureFlatArray($this->values), $this->ensureFlatArray($value)));
    }

    public function set(...$value)
    {
        $this->values = $value;
        return $this;
    }

    public function replace($original, ...$replacement)
    {
        $count_start = count($this->ensureFlatArray($this->values));
        $this->remove($original);
        if (count($this->ensureFlatArray($this->values)) !== $count_start) {
            $this->append($replacement);
        }
        return $this;
    }

    public function serialize()
    {
        return serialize(['name' => $this->name, 'values' => $this->getValuesAsArray(),]);
    }

    public function setBoolean($boolean = true)
    {
        return true === $boolean ? $this->set() : $this->append('');
    }

    public function unserialize($serialized)
    {
        $unserialized = unserialize($serialized);
        $this->name = $unserialized['name'];
        $this->values = $unserialized['values'];
    }
}