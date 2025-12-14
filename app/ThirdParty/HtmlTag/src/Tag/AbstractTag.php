<?php

namespace drupol\htmltag\Tag;

use drupol\htmltag\AbstractBaseHtmlTagObject;
use drupol\htmltag\Attribute\AttributeInterface;
use drupol\htmltag\Attributes\AttributesInterface;
use drupol\htmltag\StringableInterface;
use function array_map;
use function htmlentities;
use function implode;
use function reset;
use function serialize;
use function sprintf;
use function unserialize;

abstract class AbstractTag extends AbstractBaseHtmlTagObject implements TagInterface
{
    private $attributes;
    private $content;
    private $tag;

    public function __construct(AttributesInterface $attributes, $name, $content = null)
    {
        $this->tag = $name;
        $this->attributes = $attributes;
        $this->content($content);
    }

    public function content(...$data)
    {
        if ([] !== $data) {
            if (null === reset($data)) {
                $data = null;
            }
            $this->content = $data;
        }
        return $this->renderContent();
    }

    protected function renderContent()
    {
        return ($items = array_map([$this, 'escape'], $this->getContentAsArray())) === [] ? null : implode('', $items);
    }

    public function getContentAsArray()
    {
        return $this->preprocess($this->ensureFlatArray((array)$this->content));
    }

    public function preprocess(array $values, array $context = [])
    {
        return $values;
    }

    public static function __callStatic($name, array $arguments = [])
    {
        return new static($arguments[0], $name);
    }

    public function __toString()
    {
        return $this->render();
    }

    public function render()
    {
        return null === ($content = $this->renderContent()) ? sprintf('<%s%s/>', $this->tag, $this->attributes->render()) : sprintf('<%s%s>%s</%s>', $this->tag, $this->attributes->render(), $content, $this->tag);
    }

    public function alter(callable ...$closures)
    {
        foreach ($closures as $closure) {
            $this->content = $closure($this->ensureFlatArray((array)$this->content));
        }
        return $this;
    }

    public function attr($name = null, ...$value)
    {
        if (null === $name) {
            return $this->attributes->render();
        }
        if ([] === $value) {
            return $this->attributes[$name];
        }
        return $this->attributes[$name]->set($value);
    }

    public function escape($value)
    {
        $return = $this->ensureString($value);
        if ($value instanceof StringableInterface) {
            return $return;
        }
        return null === $return ? $return : htmlentities($return);
    }

    public function serialize()
    {
        return serialize(['tag' => $this->tag, 'attributes' => $this->attributes->getValuesAsArray(), 'content' => $this->renderContent(),]);
    }

    public function unserialize($serialized)
    {
        $unserialize = unserialize($serialized);
        $this->tag = $unserialize['tag'];
        $this->attributes = $this->attributes->import($unserialize['attributes']);
        $this->content = $unserialize['content'];
    }
}