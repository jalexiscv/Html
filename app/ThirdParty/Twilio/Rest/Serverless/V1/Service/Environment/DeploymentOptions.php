<?php

namespace Twilio\Rest\Serverless\V1\Service\Environment;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class DeploymentOptions
{
    public static function create(string $buildSid = Values::NONE): CreateDeploymentOptions
    {
        return new CreateDeploymentOptions($buildSid);
    }
}

class CreateDeploymentOptions extends Options
{
    public function __construct(string $buildSid = Values::NONE)
    {
        $this->options['buildSid'] = $buildSid;
    }

    public function setBuildSid(string $buildSid): self
    {
        $this->options['buildSid'] = $buildSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Serverless.V1.CreateDeploymentOptions ' . $options . ']';
    }
}