<?php

namespace Twilio\Rest\Preview\DeployedDevices;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class FleetOptions
{
    public static function create(string $friendlyName = Values::NONE): CreateFleetOptions
    {
        return new CreateFleetOptions($friendlyName);
    }

    public static function update(string $friendlyName = Values::NONE, string $defaultDeploymentSid = Values::NONE): UpdateFleetOptions
    {
        return new UpdateFleetOptions($friendlyName, $defaultDeploymentSid);
    }
}

class CreateFleetOptions extends Options
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
        return '[Twilio.Preview.DeployedDevices.CreateFleetOptions ' . $options . ']';
    }
}

class UpdateFleetOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $defaultDeploymentSid = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['defaultDeploymentSid'] = $defaultDeploymentSid;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setDefaultDeploymentSid(string $defaultDeploymentSid): self
    {
        $this->options['defaultDeploymentSid'] = $defaultDeploymentSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Preview.DeployedDevices.UpdateFleetOptions ' . $options . ']';
    }
}