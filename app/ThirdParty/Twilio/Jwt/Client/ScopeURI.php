<?php

namespace Twilio\Jwt\Client;

use UnexpectedValueException;
use function count;
use function explode;
use function http_build_query;
use function parse_str;
use function strpos;

class ScopeURI
{
    public $service;
    public $privilege;
    public $params;

    public function __construct(string $service, string $privilege, array $params = [])
    {
        $this->service = $service;
        $this->privilege = $privilege;
        $this->params = $params;
    }

    public function toString(): string
    {
        $uri = "scope:{$this->service}:{$this->privilege}";
        if (count($this->params)) {
            $uri .= '?' . http_build_query($this->params, '', '&');
        }
        return $uri;
    }

    public static function parse(string $uri): ScopeURI
    {
        if (strpos($uri, 'scope:') !== 0) {
            throw new UnexpectedValueException('Not a scope URI according to scheme');
        }
        $parts = explode('?', $uri, 1);
        $params = null;
        if (count($parts) > 1) {
            parse_str($parts[1], $params);
        }
        $parts = explode(':', $parts[0], 2);
        if (count($parts) !== 3) {
            throw new UnexpectedValueException('Not enough parts for scope URI');
        }
        [$scheme, $service, $privilege] = $parts;
        return new ScopeURI($service, $privilege, $params);
    }
}