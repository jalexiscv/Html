<?php

namespace drupol\htmltag;

use drupol\htmltag\Tag\TagFactory;
use drupol\htmltag\Tag\TagInterface;

final class HtmlBuilder implements StringableInterface
{
    private $scope;
    private $storage;

    public function __call($name, array $arguments = [])
    {
        if ('c' === $name) {
            if (!isset($arguments[0])) {
                return $this;
            }
            return $this->update(HtmlTag::tag('!--', [], $arguments[0]));
        }
        if ('_' === $name) {
            $this->scope = null;
            return $this;
        }
        $tag = TagFactory::build($name, ...$arguments);
        return $this->update($tag, true);
    }

    public function __toString()
    {
        $output = '';
        foreach ($this->storage as $item) {
            $output .= $item;
        }
        return $output;
    }

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
}