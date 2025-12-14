<?php

namespace Higgs\Publisher\Exceptions;

use Higgs\Exceptions\FrameworkException;

class PublisherException extends FrameworkException
{
    public static function forCollision(string $from, string $to)
    {
        return new static(lang('Publisher.collision', [filetype($to), $from, $to]));
    }

    public static function forDestinationNotAllowed(string $destination)
    {
        return new static(lang('Publisher.destinationNotAllowed', [$destination]));
    }

    public static function forFileNotAllowed(string $file, string $directory, string $pattern)
    {
        return new static(lang('Publisher.fileNotAllowed', [$file, $directory, $pattern]));
    }
}