<?php

namespace Facebook\PseudoRandomString;

use Facebook\Exceptions\FacebookSDKException;

class RandomBytesPseudoRandomStringGenerator implements PseudoRandomStringGeneratorInterface
{
    use PseudoRandomStringGeneratorTrait;

    const ERROR_MESSAGE = 'Unable to generate a cryptographically secure pseudo-random string from random_bytes(). ';

    public function __construct()
    {
        if (!function_exists('random_bytes')) {
            throw new FacebookSDKException(static::ERROR_MESSAGE . 'The function random_bytes() does not exist.');
        }
    }

    public function getPseudoRandomString($length)
    {
        $this->validateLength($length);
        return $this->binToHex(random_bytes($length), $length);
    }
}