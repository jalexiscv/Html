<?php

namespace Higgs\Filters\Exceptions;

use Higgs\Exceptions\ConfigException;
use Higgs\Exceptions\ExceptionInterface;

class FilterException extends ConfigException implements ExceptionInterface
{
    public static function forNoAlias(string $alias)
    {
        return new static(lang('Filters.noFilter', [$alias]));
    }

    public static function forIncorrectInterface(string $class)
    {
        return new static(lang('Filters.incorrectInterface', [$class]));
    }
}