<?php

namespace Higgs\Pager\Exceptions;

use Higgs\Exceptions\FrameworkException;

class PagerException extends FrameworkException
{
    public static function forInvalidTemplate(?string $template = null)
    {
        return new static(lang('Pager.invalidTemplate', [$template]));
    }

    public static function forInvalidPaginationGroup(?string $group = null)
    {
        return new static(lang('Pager.invalidPaginationGroup', [$group]));
    }
}