<?php

namespace drupol\htmltag\Attribute;
interface AttributeFactoryInterface
{
    public static function build($name, $value = null);

    public function getInstance($name, $value = null);
}