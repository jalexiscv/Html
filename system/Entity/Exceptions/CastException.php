<?php

namespace Higgs\Entity\Exceptions;

use Higgs\Exceptions\FrameworkException;
use Higgs\Exceptions\HasExitCodeInterface;

class CastException extends FrameworkException implements HasExitCodeInterface
{
    public static function forInvalidInterface(string $class)
    {
        return new static(lang('Cast.baseCastMissing', [$class]));
    }

    public static function forInvalidJsonFormat(int $error)
    {
        switch ($error) {
            case JSON_ERROR_DEPTH:
                return new static(lang('Cast.jsonErrorDepth'));
            case JSON_ERROR_STATE_MISMATCH:
                return new static(lang('Cast.jsonErrorStateMismatch'));
            case JSON_ERROR_CTRL_CHAR:
                return new static(lang('Cast.jsonErrorCtrlChar'));
            case JSON_ERROR_SYNTAX:
                return new static(lang('Cast.jsonErrorSyntax'));
            case JSON_ERROR_UTF8:
                return new static(lang('Cast.jsonErrorUtf8'));
            default:
                return new static(lang('Cast.jsonErrorUnknown'));
        }
    }

    public static function forInvalidMethod(string $method)
    {
        return new static(lang('Cast.invalidCastMethod', [$method]));
    }

    public static function forInvalidTimestamp()
    {
        return new static(lang('Cast.invalidTimestamp'));
    }

    public function getExitCode(): int
    {
        return EXIT_CONFIG;
    }
}