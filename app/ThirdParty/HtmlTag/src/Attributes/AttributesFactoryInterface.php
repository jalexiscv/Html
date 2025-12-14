<?php

namespace drupol\htmltag\Attributes;
interface AttributesFactoryInterface
{
    public static function build(array $attributes = []);

    public function getInstance(array $attributes = []);
}