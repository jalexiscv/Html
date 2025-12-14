<?php

namespace Twilio\Rest\Lookups\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class PhoneNumberOptions
{
    public static function fetch(string $countryCode = Values::NONE, array $type = Values::ARRAY_NONE, array $addOns = Values::ARRAY_NONE, string $addOnsData = Values::NONE): FetchPhoneNumberOptions
    {
        return new FetchPhoneNumberOptions($countryCode, $type, $addOns, $addOnsData);
    }
}

class FetchPhoneNumberOptions extends Options
{
    public function __construct(string $countryCode = Values::NONE, array $type = Values::ARRAY_NONE, array $addOns = Values::ARRAY_NONE, string $addOnsData = Values::NONE)
    {
        $this->options['countryCode'] = $countryCode;
        $this->options['type'] = $type;
        $this->options['addOns'] = $addOns;
        $this->options['addOnsData'] = $addOnsData;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->options['countryCode'] = $countryCode;
        return $this;
    }

    public function setType(array $type): self
    {
        $this->options['type'] = $type;
        return $this;
    }

    public function setAddOns(array $addOns): self
    {
        $this->options['addOns'] = $addOns;
        return $this;
    }

    public function setAddOnsData(string $addOnsData): self
    {
        $this->options['addOnsData'] = $addOnsData;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Lookups.V1.FetchPhoneNumberOptions ' . $options . ']';
    }
}