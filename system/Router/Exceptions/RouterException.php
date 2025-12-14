<?php

namespace Higgs\Router\Exceptions;

use Higgs\Exceptions\FrameworkException;

class RouterException extends FrameworkException
{
    public static function forInvalidParameterType()
    {
        return new static(lang('Router.invalidParameterType'));
    }

    public static function forMissingDefaultRoute()
    {
        return new static(lang('Router.missingDefaultRoute'));
    }

    public static function forControllerNotFound(string $controller, string $method)
    {
        return new static(lang('HTTP.controllerNotFound', [$controller, $method]));
    }

    public static function forInvalidRoute(string $route)
    {
        return new static(lang('HTTP.invalidRoute', [$route]));
    }

    public static function forDynamicController(string $handler)
    {
        return new static(lang('Router.invalidDynamicController', [$handler]));
    }

    public static function forInvalidControllerName(string $handler)
    {
        return new static(lang('Router.invalidControllerName', [$handler]));
    }
}