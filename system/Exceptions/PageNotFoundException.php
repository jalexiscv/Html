<?php

namespace Higgs\Exceptions;

use Config\Services;
use OutOfBoundsException;

class PageNotFoundException extends OutOfBoundsException implements ExceptionInterface, HTTPExceptionInterface
{
    use DebugTraceableTrait;

    protected $code = 404;

    public static function forPageNotFound(?string $message = null)
    {
        return new static($message ?? self::lang('HTTP.pageNotFound'));
    }

    private static function lang(string $line, array $args = []): string
    {
        $lang = Services::language(null, false);
        return $lang->getLine($line, $args);
    }

    public static function forEmptyController()
    {
        return new static(self::lang('HTTP.emptyController'));
    }

    public static function forControllerNotFound(string $controller, string $method)
    {
        return new static(self::lang('HTTP.controllerNotFound', [$controller, $method]));
    }

    public static function forMethodNotFound(string $method)
    {
        return new static(self::lang('HTTP.methodNotFound', [$method]));
    }

    public static function forLocaleNotSupported(string $locale)
    {
        return new static(self::lang('HTTP.localeNotSupported', [$locale]));
    }
}