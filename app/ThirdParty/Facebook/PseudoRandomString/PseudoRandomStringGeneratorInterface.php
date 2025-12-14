<?php

namespace Facebook\PseudoRandomString;

use Facebook\Exceptions\FacebookSDKException;
use InvalidArgumentException;

interface PseudoRandomStringGeneratorInterface
{
    public function getPseudoRandomString($length);
}