<?php

namespace Twilio\Rest\Pricing\V2\Voice;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class NumberOptions
{
    public static function fetch(string $originationNumber = Values::NONE): FetchNumberOptions
    {
        return new FetchNumberOptions($originationNumber);
    }
}

class FetchNumberOptions extends Options
{
    public function __construct(string $originationNumber = Values::NONE)
    {
        $this->options['originationNumber'] = $originationNumber;
    }

    public function setOriginationNumber(string $originationNumber): self
    {
        $this->options['originationNumber'] = $originationNumber;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Pricing.V2.FetchNumberOptions ' . $options . ']';
    }
}