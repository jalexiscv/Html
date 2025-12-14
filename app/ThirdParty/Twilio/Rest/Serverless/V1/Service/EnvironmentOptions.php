<?php

namespace Twilio\Rest\Serverless\V1\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class EnvironmentOptions
{
    public static function create(string $domainSuffix = Values::NONE): CreateEnvironmentOptions
    {
        return new CreateEnvironmentOptions($domainSuffix);
    }
}

class CreateEnvironmentOptions extends Options
{
    public function __construct(string $domainSuffix = Values::NONE)
    {
        $this->options['domainSuffix'] = $domainSuffix;
    }

    public function setDomainSuffix(string $domainSuffix): self
    {
        $this->options['domainSuffix'] = $domainSuffix;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Serverless.V1.CreateEnvironmentOptions ' . $options . ']';
    }
}