<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlList;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class IpAddressOptions
{
    public static function create(int $cidrPrefixLength = Values::NONE): CreateIpAddressOptions
    {
        return new CreateIpAddressOptions($cidrPrefixLength);
    }

    public static function update(string $ipAddress = Values::NONE, string $friendlyName = Values::NONE, int $cidrPrefixLength = Values::NONE): UpdateIpAddressOptions
    {
        return new UpdateIpAddressOptions($ipAddress, $friendlyName, $cidrPrefixLength);
    }
}

class CreateIpAddressOptions extends Options
{
    public function __construct(int $cidrPrefixLength = Values::NONE)
    {
        $this->options['cidrPrefixLength'] = $cidrPrefixLength;
    }

    public function setCidrPrefixLength(int $cidrPrefixLength): self
    {
        $this->options['cidrPrefixLength'] = $cidrPrefixLength;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateIpAddressOptions ' . $options . ']';
    }
}

class UpdateIpAddressOptions extends Options
{
    public function __construct(string $ipAddress = Values::NONE, string $friendlyName = Values::NONE, int $cidrPrefixLength = Values::NONE)
    {
        $this->options['ipAddress'] = $ipAddress;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['cidrPrefixLength'] = $cidrPrefixLength;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->options['ipAddress'] = $ipAddress;
        return $this;
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
        return '[Twilio.Api.V2010.UpdateIpAddressOptions ' . $options . ']';
    }
}