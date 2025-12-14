<?php

namespace drupol\htmltag\Tag;

use drupol\htmltag\AlterableInterface;
use drupol\htmltag\Attribute\AttributeInterface;
use drupol\htmltag\EscapableInterface;
use drupol\htmltag\PreprocessableInterface;
use drupol\htmltag\RenderableInterface;
use drupol\htmltag\StringableInterface;
use Serializable;

interface TagInterface extends Serializable, AlterableInterface, EscapableInterface, PreprocessableInterface, RenderableInterface, StringableInterface
{
    public function attr($name = null, ...$value);

    public function content(...$data);

    public function getContentAsArray();
}