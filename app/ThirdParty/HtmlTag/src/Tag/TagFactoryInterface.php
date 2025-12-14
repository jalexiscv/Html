<?php

namespace drupol\htmltag\Tag;
interface TagFactoryInterface
{
    public static function build($name, array $attributes = [], $content = null);

    public function getInstance($name, array $attributes = [], $content = null);
}