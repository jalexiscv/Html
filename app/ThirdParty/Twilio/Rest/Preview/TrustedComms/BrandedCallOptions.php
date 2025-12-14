<?php

namespace Twilio\Rest\Preview\TrustedComms;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class BrandedCallOptions
{
    public static function create(string $callSid = Values::NONE): CreateBrandedCallOptions
    {
        return new CreateBrandedCallOptions($callSid);
    }
}

class CreateBrandedCallOptions extends Options
{
    public function __construct(string $callSid = Values::NONE)
    {
        $this->options['callSid'] = $callSid;
    }

    public function setCallSid(string $callSid): self
    {
        $this->options['callSid'] = $callSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.TrustedComms.CreateBrandedCallOptions ' . $options . ']';
    }
}