<?php

declare(strict_types=1);

namespace Higgs\Html\Attribute;

use Exception;
use ReflectionClass;
use function in_array;

class AttributeFactory implements AttributeFactoryInterface
{
    /**
     * El registro de clases.
     *
     * @var array<string, string>
     */
    public static $registry = [
        'class' => ClassAttribute::class,
        '*' => Attribute::class,
    ];

    public static function build(string $name, $value = null): AttributeInterface
    {
        return (new static())->getInstance($name, $value);
    }

    public function getInstance(string $name, $value = null): AttributeInterface
    {
        $attribute_classname = static::$registry[$name] ?? static::$registry['*'];

        if (!in_array(AttributeInterface::class, class_implements($attribute_classname), true)) {
            throw new Exception(
                sprintf(
                    'The class (%s) must implement the interface %s.',
                    $attribute_classname,
                    AttributeInterface::class
                )
            );
        }

        if ($attribute_classname === Attribute::class) {
            return new Attribute($name, $value);
        }

        /** @var AttributeInterface $attribute */
        $attribute = (new ReflectionClass($attribute_classname))
            ->newInstanceArgs([
                $name,
                $value,
            ]);

        return $attribute;
    }
}
