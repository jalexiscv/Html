<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class TokenOptions
{
    public static function create(int $ttl = Values::NONE): CreateTokenOptions
    {
        return new CreateTokenOptions($ttl);
    }
}

class CreateTokenOptions extends Options
{
    public function __construct(int $ttl = Values::NONE)
    {
        $this->options['ttl'] = $ttl;
    }

    public function setTtl(int $ttl): self
    {
        $this->options['ttl'] = $ttl;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateTokenOptions ' . $options . ']';
    }
}