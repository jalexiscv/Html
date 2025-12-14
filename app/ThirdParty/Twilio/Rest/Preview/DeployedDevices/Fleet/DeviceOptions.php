<?php

namespace Twilio\Rest\Preview\DeployedDevices\Fleet;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class DeviceOptions
{
    public static function create(string $uniqueName = Values::NONE, string $friendlyName = Values::NONE, string $identity = Values::NONE, string $deploymentSid = Values::NONE, bool $enabled = Values::NONE): CreateDeviceOptions
    {
        return new CreateDeviceOptions($uniqueName, $friendlyName, $identity, $deploymentSid, $enabled);
    }

    public static function read(string $deploymentSid = Values::NONE): ReadDeviceOptions
    {
        return new ReadDeviceOptions($deploymentSid);
    }

    public static function update(string $friendlyName = Values::NONE, string $identity = Values::NONE, string $deploymentSid = Values::NONE, bool $enabled = Values::NONE): UpdateDeviceOptions
    {
        return new UpdateDeviceOptions($friendlyName, $identity, $deploymentSid, $enabled);
    }
}

class CreateDeviceOptions extends Options
{
    public function __construct(string $uniqueName = Values::NONE, string $friendlyName = Values::NONE, string $identity = Values::NONE, string $deploymentSid = Values::NONE, bool $enabled = Values::NONE)
    {
        $this->options['uniqueName'] = $uniqueName;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['identity'] = $identity;
        $this->options['deploymentSid'] = $deploymentSid;
        $this->options['enabled'] = $enabled;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setIdentity(string $identity): self
    {
        $this->options['identity'] = $identity;
        return $this;
    }

    public function setDeploymentSid(string $deploymentSid): self
    {
        $this->options['deploymentSid'] = $deploymentSid;
        return $this;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->options['enabled'] = $enabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.DeployedDevices.CreateDeviceOptions ' . $options . ']';
    }
}

class ReadDeviceOptions extends Options
{
    public function __construct(string $deploymentSid = Values::NONE)
    {
        $this->options['deploymentSid'] = $deploymentSid;
    }

    public function setDeploymentSid(string $deploymentSid): self
    {
        $this->options['deploymentSid'] = $deploymentSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.DeployedDevices.ReadDeviceOptions ' . $options . ']';
    }
}

class UpdateDeviceOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $identity = Values::NONE, string $deploymentSid = Values::NONE, bool $enabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['identity'] = $identity;
        $this->options['deploymentSid'] = $deploymentSid;
        $this->options['enabled'] = $enabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setIdentity(string $identity): self
    {
        $this->options['identity'] = $identity;
        return $this;
    }

    public function setDeploymentSid(string $deploymentSid): self
    {
        $this->options['deploymentSid'] = $deploymentSid;
        return $this;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->options['enabled'] = $enabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.DeployedDevices.UpdateDeviceOptions ' . $options . ']';
    }
}