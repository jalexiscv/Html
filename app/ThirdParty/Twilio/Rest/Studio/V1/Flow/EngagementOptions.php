<?php

namespace Twilio\Rest\Studio\V1\Flow;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class EngagementOptions
{
    public static function create(array $parameters = Values::ARRAY_NONE): CreateEngagementOptions
    {
        return new CreateEngagementOptions($parameters);
    }
}

class CreateEngagementOptions extends Options
{
    public function __construct(array $parameters = Values::ARRAY_NONE)
    {
        $this->options['parameters'] = $parameters;
    }

    public function setParameters(array $parameters): self
    {
        $this->options['parameters'] = $parameters;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Studio.V1.CreateEngagementOptions ' . $options . ']';
    }
}