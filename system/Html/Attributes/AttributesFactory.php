<?php

declare(strict_types=1);

namespace Higgs\Html\Attributes;

use Higgs\Html\Attribute\AttributeFactory;
use Higgs\Html\Attribute\AttributeFactoryInterface;
use ReflectionClass;

class AttributesFactory implements AttributesFactoryInterface
{
    /**
     * El registro de clases.
     *
     * @var array
     */
    public static $registry = [
        'attribute_factory' => AttributeFactory::class,
        '*' => Attributes::class,
    ];

    public static function build(
        array $attributes = []
    )
    {
        return (new static())->getInstance($attributes);
    }

    public function getInstance(
        array $attributes = []
    )
    {
        $attribute_factory_classname = static::$registry['attribute_factory'];

        /** @var AttributeFactoryInterface $attribute_factory_classname */
        $attribute_factory_classname = (new ReflectionClass($attribute_factory_classname))->newInstance();

        $attributes_classname = static::$registry['*'];

        /** @var AttributesInterface $attributes */
        $attributes = (new ReflectionClass($attributes_classname))
            ->newInstanceArgs([
                $attribute_factory_classname,
                $attributes,
            ]);

        return $attributes;
    }
}
