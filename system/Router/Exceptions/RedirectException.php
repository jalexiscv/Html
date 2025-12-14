<?php

namespace Higgs\Router\Exceptions;

use Higgs\Exceptions\HTTPExceptionInterface;
use Exception;

class RedirectException extends Exception implements HTTPExceptionInterface
{
    protected $code = 302;
}