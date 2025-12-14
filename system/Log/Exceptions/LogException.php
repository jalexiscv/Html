<?php

namespace Higgs\Log\Exceptions;

use Higgs\Exceptions\FrameworkException;

class LogException extends FrameworkException
{
    public static function forInvalidLogLevel(string $level)
    {
        return new static(lang('Log.invalidLogLevel', [$level]));
    }

    public static function forInvalidMessageType(string $messageType)
    {
        return new static(lang('Log.invalidMessageType', [$messageType]));
    }
}