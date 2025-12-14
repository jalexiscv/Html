<?php

declare(strict_types=1);

namespace Higgs\Html\Tag;

use Exception;
use Higgs\Html\Attributes\AttributesFactory;
use Higgs\Html\Attributes\AttributesInterface;
use ReflectionClass;
use function in_array;

class TagFactory implements TagFactoryInterface
{
    /**
     * El registro de clases.
     *
     * @var array<string, string>
     */
    public static $registry = [
        'attributes_factory' => AttributesFactory::class,
        '!--' => Comment::class,
        '*' => Tag::class,
    ];

    public static function build(
        string $name,
        array  $attributes = [],
               $content = null
    ): TagInterface
    {
        return (new static())->getInstance($name, $attributes, $content);
    }

    public function getInstance(
        string $name,
        array  $attributes = [],
               $content = null
    ): TagInterface
    {
        $attributes_factory_classname = static::$registry['attributes_factory'];

        /** @var AttributesInterface $attributes */
        $attributes = $attributes_factory_classname::build($attributes);

        $tag_classname = static::$registry[$name] ?? static::$registry['*'];

        if (!in_array(TagInterface::class, class_implements($tag_classname), true)) {
            throw new Exception(
                sprintf(
                    'The class (%s) must implement the interface %s.',
                    $tag_classname,
                    TagInterface::class
                )
            );
        }

        if ($tag_classname === Tag::class) {
            return new Tag($attributes, $name, $content);
        }

        /** @var TagInterface $tag */
        $tag = (new ReflectionClass($tag_classname))
            ->newInstanceArgs([
                $attributes,
                $name,
                $content,
            ]);

        return $tag;
    }
}
