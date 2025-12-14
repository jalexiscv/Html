<?php

namespace Facebook\PseudoRandomString;

use InvalidArgumentException;
use function bin2hex;
use function substr;

trait PseudoRandomStringGeneratorTrait
{
    public function validateLength($length)
    {
        if (!is_int($length)) {
            throw new InvalidArgumentException('getPseudoRandomString() expects an integer for the string length');
        }
        if ($length < 1) {
            throw new InvalidArgumentException('getPseudoRandomString() expects a length greater than 1');
        }
    }

    public function binToHex($binaryData, $length)
    {
        return substr(bin2hex($binaryData), 0, $length);
    }
}