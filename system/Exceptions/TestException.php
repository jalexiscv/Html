<?php

namespace Higgs\Exceptions;
class TestException extends CriticalError
{
    use DebugTraceableTrait;

    public static function forInvalidMockClass(string $name)
    {
        return new static(lang('Test.invalidMockClass', [$name]));
    }
}