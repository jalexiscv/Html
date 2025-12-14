<?php

namespace Higgs\View;
interface ViewDecoratorInterface
{
    public static function decorate(string $html): string;
}