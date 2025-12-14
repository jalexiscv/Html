<?php

namespace Twilio\Rest\Preview\DeployedDevices\Fleet;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class DeploymentOptions
{
    public static function create(string $friendlyName = Values::NONE, string $syncServiceSid = Values::NONE): CreateDeploymentOptions
    {
        return new CreateDeploymentOptions($friendlyName, $syncServiceSid);
    }

    public static function update(string $friendlyName = Values::NONE, string $syncServiceSid = Values::NONE): UpdateDeploymentOptions
    {
        return new UpdateDeploymentOptions($friendlyName, $syncServiceSid);
    }
}

class CreateDeploymentOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $syncServiceSid = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['syncServiceSid'] = $syncServiceSid;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setSyncServiceSid(string $syncServiceSid): self
    {
        $this->options['syncServiceSid'] = $syncServiceSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.DeployedDevices.CreateDeploymentOptions ' . $options . ']';
    }
}

class UpdateDeploymentOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $syncServiceSid = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['syncServiceSid'] = $syncServiceSid;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setSyncServiceSid(string $syncServiceSid): self
    {
        $this->options['syncServiceSid'] = $syncServiceSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.DeployedDevices.UpdateDeploymentOptions ' . $options . ']';
    }
}