<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CpsOptions
{
    public static function fetch(string $xXcnamSensitivePhoneNumber = Values::NONE): FetchCpsOptions
    {
        return new FetchCpsOptions($xXcnamSensitivePhoneNumber);
    }
}

class FetchCpsOptions extends Options
{
    public function __construct(string $xXcnamSensitivePhoneNumber = Values::NONE)
    {
        $this->options['xXcnamSensitivePhoneNumber'] = $xXcnamSensitivePhoneNumber;
    }

    public function setXXcnamSensitivePhoneNumber(string $xXcnamSensitivePhoneNumber): self
    {
        $this->options['xXcnamSensitivePhoneNumber'] = $xXcnamSensitivePhoneNumber;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.TrustedComms.FetchCpsOptions ' . $options . ']';
    }
}