<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CurrentCallOptions
{
    public static function fetch(string $xXcnamSensitivePhoneNumberFrom = Values::NONE, string $xXcnamSensitivePhoneNumberTo = Values::NONE): FetchCurrentCallOptions
    {
        return new FetchCurrentCallOptions($xXcnamSensitivePhoneNumberFrom, $xXcnamSensitivePhoneNumberTo);
    }
}

class FetchCurrentCallOptions extends Options
{
    public function __construct(string $xXcnamSensitivePhoneNumberFrom = Values::NONE, string $xXcnamSensitivePhoneNumberTo = Values::NONE)
    {
        $this->options['xXcnamSensitivePhoneNumberFrom'] = $xXcnamSensitivePhoneNumberFrom;
        $this->options['xXcnamSensitivePhoneNumberTo'] = $xXcnamSensitivePhoneNumberTo;
    }

    public function setXXcnamSensitivePhoneNumberFrom(string $xXcnamSensitivePhoneNumberFrom): self
    {
        $this->options['xXcnamSensitivePhoneNumberFrom'] = $xXcnamSensitivePhoneNumberFrom;
        return $this;
    }

    public function setXXcnamSensitivePhoneNumberTo(string $xXcnamSensitivePhoneNumberTo): self
    {
        $this->options['xXcnamSensitivePhoneNumberTo'] = $xXcnamSensitivePhoneNumberTo;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.TrustedComms.FetchCurrentCallOptions ' . $options . ']';
    }
}