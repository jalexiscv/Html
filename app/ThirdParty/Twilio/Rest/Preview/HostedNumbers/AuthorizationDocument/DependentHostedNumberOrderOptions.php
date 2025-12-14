<?php

namespace Twilio\Rest\Preview\HostedNumbers\AuthorizationDocument;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class DependentHostedNumberOrderOptions
{
    public static function read(string $status = Values::NONE, string $phoneNumber = Values::NONE, string $incomingPhoneNumberSid = Values::NONE, string $friendlyName = Values::NONE, string $uniqueName = Values::NONE): ReadDependentHostedNumberOrderOptions
    {
        return new ReadDependentHostedNumberOrderOptions($status, $phoneNumber, $incomingPhoneNumberSid, $friendlyName, $uniqueName);
    }
}

class ReadDependentHostedNumberOrderOptions extends Options
{
    public function __construct(string $status = Values::NONE, string $phoneNumber = Values::NONE, string $incomingPhoneNumberSid = Values::NONE, string $friendlyName = Values::NONE, string $uniqueName = Values::NONE)
    {
        $this->options['status'] = $status;
        $this->options['phoneNumber'] = $phoneNumber;
        $this->options['incomingPhoneNumberSid'] = $incomingPhoneNumberSid;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['uniqueName'] = $uniqueName;
    }

    public function setStatus(string $status): self
    {
        $this->options['status'] = $status;
        return $this;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->options['phoneNumber'] = $phoneNumber;
        return $this;
    }

    public function setIncomingPhoneNumberSid(string $incomingPhoneNumberSid): self
    {
        $this->options['incomingPhoneNumberSid'] = $incomingPhoneNumberSid;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.HostedNumbers.ReadDependentHostedNumberOrderOptions ' . $options . ']';
    }
}