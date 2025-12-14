<?php

namespace Twilio\Rest\Voice\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class IpRecordOptions
{
    public static function create(string $friendlyName = Values::NONE, int $cidrPrefixLength = Values::NONE): CreateIpRecordOptions
    {
        return new CreateIpRecordOptions($friendlyName, $cidrPrefixLength);
    }

    public static function update(string $friendlyName = Values::NONE): UpdateIpRecordOptions
    {
        return new UpdateIpRecordOptions($friendlyName);
    }
}

class CreateIpRecordOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, int $cidrPrefixLength = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['cidrPrefixLength'] = $cidrPrefixLength;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setCidrPrefixLength(int $cidrPrefixLength): self
    {
        $this->options['cidrPrefixLength'] = $cidrPrefixLength;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Voice.V1.CreateIpRecordOptions ' . $options . ']';
    }
}

class UpdateIpRecordOptions extends Options
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
        return '[Twilio.Voice.V1.UpdateIpRecordOptions ' . $options . ']';
    }
}