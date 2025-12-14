<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class OutgoingCallerIdOptions
{
    public static function update(string $friendlyName = Values::NONE): UpdateOutgoingCallerIdOptions
    {
        return new UpdateOutgoingCallerIdOptions($friendlyName);
    }

    public static function read(string $phoneNumber = Values::NONE, string $friendlyName = Values::NONE): ReadOutgoingCallerIdOptions
    {
        return new ReadOutgoingCallerIdOptions($phoneNumber, $friendlyName);
    }
}

class UpdateOutgoingCallerIdOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateOutgoingCallerIdOptions ' . $options . ']';
    }
}

class ReadOutgoingCallerIdOptions extends Options
{
    public function __construct(string $phoneNumber = Values::NONE, string $friendlyName = Values::NONE)
    {
        $this->options['phoneNumber'] = $phoneNumber;
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->options['phoneNumber'] = $phoneNumber;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.ReadOutgoingCallerIdOptions ' . $options . ']';
    }
}