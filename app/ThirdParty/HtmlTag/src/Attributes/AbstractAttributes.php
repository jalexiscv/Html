<?php

namespace drupol\htmltag\Attributes;

use ArrayIterator;
use drupol\htmltag\AbstractBaseHtmlTagObject;
use drupol\htmltag\Attribute\AttributeFactoryInterface;
use drupol\htmltag\Attribute\AttributeInterface;
use function array_keys;
use function array_map;
use function array_values;
use function serialize;
use function unserialize;

abstract class AbstractAttributes extends AbstractBaseHtmlTagObject implements AttributesInterface
{
    private $attributeFactory;
    private $storage = [];

    public function __construct(AttributeFactoryInterface $attributeFactory, array $data = [])
    {
        $this->attributeFactory = $attributeFactory;
        $this->import($data);
    }

    public function import($data)
    {
        foreach ($data as $key => $value) {
            $this->storage[$key] = $this->attributeFactory->getInstance($key, $value);
        }
        return $this;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function render()
    {
        $output = '';
        foreach ($this->getStorage() as $attribute) {
            $output .= ' ' . $attribute;
        }
        return $output;
    }

    public function getStorage()
    {
        return new ArrayIterator(array_values($this->preprocess($this->storage)));
    }

    public function preprocess(array $values, array $context = [])
    {
        return $values;
    }

    public function count()
    {
        return $this->getStorage()->count();
    }

    public function getIterator()
    {
        return $this->getStorage();
    }

    public function merge(array ...$dataset)
    {
        foreach ($dataset as $data) {
            foreach ($data as $key => $value) {
                $this->append($key, $value);
            }
        }
        return $this;
    }

    public function append($key, ...$values)
    {
        $this->storage += [$key => $this->attributeFactory->getInstance($key),];
        $this->storage[$key]->append($values);
        return $this;
    }

    public function offsetExists($key)
    {
        return isset($this->storage[$key]);
    }

    public function offsetGet($key)
    {
        $this->storage += [$key => $this->attributeFactory->getInstance($key),];
        return $this->storage[$key];
    }

    public function offsetSet($key, $value = null)
    {
        $this->storage[$key] = $this->attributeFactory->getInstance($key, $value);
    }

    public function offsetUnset($key)
    {
        unset($this->storage[$key]);
    }

    public function remove($key, ...$values)
    {
        if (isset($this->storage[$key])) {
            $this->storage[$key]->remove($values);
        }
        return $this;
    }

    public function replace($key, $value, ...$replacements)
    {
        if (!$this->contains($key, $value)) {
            return $this;
        }
        $this->storage[$key]->replace($value, $replacements);
        return $this;
    }

    public function contains($key, ...$values)
    {
        return $this->exists($key) && $this->storage[$key]->contains($values);
    }

    public function exists($key, ...$values)
    {
        if (!isset($this->storage[$key])) {
            return false;
        }
        return [] === $values ? true : $this->contains($key, $values);
    }

    public function serialize()
    {
        return serialize(['storage' => $this->getValuesAsArray(),]);
    }

    public function getValuesAsArray()
    {
        $values = [];
        foreach ($this->getStorage() as $attribute) {
            $values[$attribute->getName()] = $attribute->getValuesAsArray();
        }
        return $values;
    }

    public function set($key, ...$value)
    {
        $this->storage[$key] = $this->attributeFactory->getInstance($key, $value);
        return $this;
    }

    public function unserialize($serialized)
    {
        $unserialize = unserialize($serialized);
        $attributeFactory = $this->attributeFactory;
        $this->storage = array_map(static function ($key, $values) use ($attributeFactory) {
            return $attributeFactory::build($key, $values);
        }, array_keys($unserialize['storage']), array_values($unserialize['storage']));
    }

    public function without(...$keys)
    {
        $attributes = clone $this;
        return $attributes->delete($keys);
    }

    public function delete(...$keys)
    {
        foreach ($this->ensureStrings($this->ensureFlatArray($keys)) as $key) {
            unset($this->storage[$key]);
        }
        return $this;
    }
}