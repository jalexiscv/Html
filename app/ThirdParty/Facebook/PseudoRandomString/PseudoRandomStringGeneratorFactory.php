<?php

namespace Facebook\PseudoRandomString;

use Facebook\Exceptions\FacebookSDKException;
use InvalidArgumentException;

class PseudoRandomStringGeneratorFactory
{
    private function __construct()
    {
    }

    public static function createPseudoRandomStringGenerator($generator)
    {
        if (!$generator) {
            return self::detectDefaultPseudoRandomStringGenerator();
        }
        if ($generator instanceof PseudoRandomStringGeneratorInterface) {
            return $generator;
        }
        if ('random_bytes' === $generator) {
            return new RandomBytesPseudoRandomStringGenerator();
        }
        if ('mcrypt' === $generator) {
            return new McryptPseudoRandomStringGenerator();
        }
        if ('openssl' === $generator) {
            return new OpenSslPseudoRandomStringGenerator();
        }
        if ('urandom' === $generator) {
            return new UrandomPseudoRandomStringGenerator();
        }
        throw new InvalidArgumentException('The pseudo random string generator must be set to "random_bytes", "mcrypt", "openssl", or "urandom", or be an instance of Facebook\PseudoRandomString\PseudoRandomStringGeneratorInterface');
    }

    private static function detectDefaultPseudoRandomStringGenerator()
    {
        if (function_exists('random_bytes')) {
            return new RandomBytesPseudoRandomStringGenerator();
        }
        if (function_exists('mcrypt_create_iv')) {
            return new McryptPseudoRandomStringGenerator();
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            return new OpenSslPseudoRandomStringGenerator();
        }
        if (!ini_get('open_basedir') && is_readable('/dev/urandom')) {
            return new UrandomPseudoRandomStringGenerator();
        }
        throw new FacebookSDKException('Unable to detect a cryptographically secure pseudo-random string generator.');
    }
}