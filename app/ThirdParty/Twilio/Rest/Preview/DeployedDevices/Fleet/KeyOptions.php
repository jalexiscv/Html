<?php

namespace Twilio\Rest\Preview\DeployedDevices\Fleet;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class KeyOptions
{
    public static function create(string $friendlyName = Values::NONE, string $deviceSid = Values::NONE): CreateKeyOptions
    {
        return new CreateKeyOptions($friendlyName, $deviceSid);
    }

    public static function read(string $deviceSid = Values::NONE): ReadKeyOptions
    {
        return new ReadKeyOptions($deviceSid);
    }

    public static function update(string $friendlyName = Values::NONE, string $deviceSid = Values::NONE): UpdateKeyOptions
    {
        return new UpdateKeyOptions($friendlyName, $deviceSid);
    }
}

class CreateKeyOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $deviceSid = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['deviceSid'] = $deviceSid;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setDeviceSid(string $deviceSid): self
    {
        $this->options['deviceSid'] = $deviceSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.DeployedDevices.CreateKeyOptions ' . $options . ']';
    }
}

class ReadKeyOptions extends Options
{
    public function __construct(string $deviceSid = Values::NONE)
    {
        $this->options['deviceSid'] = $deviceSid;
    }

    public function setDeviceSid(string $deviceSid): self
    {
        $this->options['deviceSid'] = $deviceSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.DeployedDevices.ReadKeyOptions ' . $options . ']';
    }
}

class UpdateKeyOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $deviceSid = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['deviceSid'] = $deviceSid;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setDeviceSid(string $deviceSid): self
    {
        $this->options['deviceSid'] = $deviceSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.DeployedDevices.UpdateKeyOptions ' . $options . ']';
    }
}