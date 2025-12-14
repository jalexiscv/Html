<?php

declare(strict_types=1);

namespace Higgs\Html\Attributes;

use ArrayIterator;
use Higgs\Html\AbstractBaseHtmlTagObject;
use Higgs\Html\Attribute\AttributeFactoryInterface;
use ReturnTypeWillChange;
use function array_key_exists;

abstract class AbstractAttributes extends AbstractBaseHtmlTagObject implements AttributesInterface
{
    /**
     * El almacenamiento de atributos.
     *
     * @var array
     */
    protected array $storage = [];

    public function __construct(
        private readonly AttributeFactoryInterface $attributeFactory,
        array $data = []
    ) {
        $this->import($data);
    }

    public function import($data): AttributesInterface
    {
        foreach ($data as $key => $value) {
            $this->storage[$key] = $this->attributeFactory->getInstance($key, $value);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        $output = '';

        foreach ($this->getStorage() as $attribute) {
            $output .= ' ' . $attribute;
        }

        return $output;
    }

    public function getStorage(): ArrayIterator
    {
        return new ArrayIterator(array_values($this->preprocess($this->storage)));
    }

    public function preprocess(array $values, array $context = []): array
    {
        return $values;
    }

    public function count(): int
    {
        return $this->getStorage()->count();
    }

    public function getIterator(): \Traversable
    {
        return $this->getStorage();
    }

    public function merge(array ...$dataset): AttributesInterface
    {
        foreach ($dataset as $data) {
            foreach ($data as $key => $value) {
                $this->append($key, $value);
            }
        }

        return $this;
    }

    public function append($key, ...$values): AttributesInterface
    {
        $this->storage += [
            $key => $this->attributeFactory->getInstance($key),
        ];

        $this->storage[$key]->append($values);

        return $this;
    }

    /**
     * @param mixed $key
     *
     * @return bool
     */
    public function offsetExists($key): bool
    {
        return isset($this->storage[$key]);
    }

    /**
     * @param mixed $key
     *
     * @return mixed
     */
    public function offsetGet($key): mixed
    {
        $this->storage += [
            $key => $this->attributeFactory->getInstance((string)$key),
        ];
        return ($this->storage[$key]);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        $this->storage[$key] = $this->attributeFactory->getInstance((string)$key, $value);
    }

    /**
     * @param mixed $key
     *
     * @return void
     */
    public function offsetUnset($key): void
    {
        unset($this->storage[$key]);
    }

    public function remove(string $key, ...$values): AttributesInterface
    {
        if (array_key_exists($key, $this->storage)) {
            $this->storage[$key]->remove(...$values);
        }

        return $this;
    }

    public function replace(string $key, string $value, string ...$replacements): AttributesInterface
    {
        if (!$this->contains($key, $value)) {
            return $this;
        }

        $this->storage[$key]->replace($value, ...$replacements);

        return $this;
    }

    public function contains(string $key, ...$values): bool
    {
        return $this->exists($key) && $this->storage[$key]->contains(...$values);
    }

    public function exists(string $key, ...$values): bool
    {
        if (!isset($this->storage[$key])) {
            return false;
        }

        return [] === $values ?
            true :
            $this->contains($key, $values);
    }

    public function __serialize(): array
    {
        return [
            'storage' => $this->getValuesAsArray(),
        ];
    }

    public function getValuesAsArray(): array
    {
        $values = [];

        foreach ($this->getStorage() as $attribute) {
            $values[$attribute->getName()] = $attribute->getValuesAsArray();
        }

        return $values;
    }

    public function set(string $key, ...$value): AttributesInterface
    {
        $this->storage[$key] = $this->attributeFactory->getInstance($key, $value);

        return $this;
    }

    public function __unserialize(array $data): void
    {
        if (!isset($this->attributeFactory)) {
             $this->attributeFactory = new \Higgs\Html\Attribute\AttributeFactory();
        }
        
        $attributeFactory = $this->attributeFactory;

        $this->storage = array_map(
             static function ($key, $values) use ($attributeFactory) {
                 return $attributeFactory->getInstance((string)$key, $values);
             },
             array_keys($data['storage']),
             array_values($data['storage'])
        );
    }

    public function without(string ...$keys): AttributesInterface
    {
        $attributes = clone $this;

        return $attributes->delete(...$keys);
    }

    public function delete(string ...$keys): AttributesInterface
    {
        foreach ($this->ensureStrings($this->ensureFlatArray($keys)) as $key) {
            unset($this->storage[$key]);
        }

        return $this;
    }
}
