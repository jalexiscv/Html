<?php

namespace drupol\htmltag\Attribute;

use ArrayAccess;
use drupol\htmltag\AlterableInterface;
use drupol\htmltag\EscapableInterface;
use drupol\htmltag\PreprocessableInterface;
use drupol\htmltag\RenderableInterface;
use drupol\htmltag\StringableInterface;
use Serializable;

interface AttributeInterface extends ArrayAccess, Serializable, AlterableInterface, EscapableInterface, PreprocessableInterface, RenderableInterface, StringableInterface
{
    public function alter(callable ...$closures);

    public function append(...$value);

    public function contains(...$substring);

    public function delete();

    public function getName();

    public function getValuesAsArray();

    public function getValuesAsString();

    public function isBoolean();

    public function remove(...$value);

    public function replace($original, ...$replacement);

    public function set(...$value);

    public function setBoolean($boolean = true);
}