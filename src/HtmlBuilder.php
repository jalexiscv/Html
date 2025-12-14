<?php

declare(strict_types=1);

namespace Higgs\Html;

use Higgs\Html\Tag\TagFactory;
use Higgs\Html\Tag\TagInterface;

/**
 * Clase HtmlBuilder.
 */
final class HtmlBuilder implements StringableInterface
{
    /**
     * El ámbito de la etiqueta actual.
     *
     * @var TagInterface|null
     */
    private ?TagInterface $scope = null;

    /**
     * El almacenamiento.
     *
     * @var TagInterface[]|string[]
     */
    private array $storage = [];

    public function __call($name, array $arguments = [])
    {
        if ('c' === $name) {
            if (!isset($arguments[0])) {
                return $this;
            }

            return $this->update(
                HtmlTag::tag('!--', [], $arguments[0])
            );
        }

        if ('_' === $name) {
            $this->scope = null;

            return $this;
        }

        $tag = TagFactory::build($name, ...$arguments);

        return $this->update($tag, true);
    }

    /**
     * Añade la etiqueta actual a la pila.
     *
     * @param TagInterface $tag
     *   La etiqueta.
     * @param bool $updateScope
     *   Verdadero si el ámbito actual necesita ser actualizado.
     *
     * @return HtmlBuilder
     *   El objeto Html Builder.
     */
    private function update(TagInterface $tag, $updateScope = false)
    {
        if (null !== $this->scope) {
            $this->scope->content($this->scope->getContentAsArray(), $tag);
        } else {
            $this->storage[] = $tag;
        }

        if (true === $updateScope) {
            $this->scope = $tag;
        }

        return $this;
    }

    public function __toString(): string
    {
        $output = '';

        foreach ($this->storage as $item) {
            $output .= $item;
        }

        return $output;
    }
}
