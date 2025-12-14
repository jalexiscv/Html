<?php

namespace Twilio\Rest\Preview\DeployedDevices\Fleet;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class CertificateOptions
{
    public static function create(string $friendlyName = Values::NONE, string $deviceSid = Values::NONE): CreateCertificateOptions
    {
        return new CreateCertificateOptions($friendlyName, $deviceSid);
    }

    public static function read(string $deviceSid = Values::NONE): ReadCertificateOptions
    {
        return new ReadCertificateOptions($deviceSid);
    }

    public static function update(string $friendlyName = Values::NONE, string $deviceSid = Values::NONE): UpdateCertificateOptions
    {
        return new UpdateCertificateOptions($friendlyName, $deviceSid);
    }
}

class CreateCertificateOptions extends Options
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
        return '[Twilio.Preview.DeployedDevices.CreateCertificateOptions ' . $options . ']';
    }
}

class ReadCertificateOptions extends Options
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
        return '[Twilio.Preview.DeployedDevices.ReadCertificateOptions ' . $options . ']';
    }
}

class UpdateCertificateOptions extends Options
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
        return '[Twilio.Preview.DeployedDevices.UpdateCertificateOptions ' . $options . ']';
    }
}