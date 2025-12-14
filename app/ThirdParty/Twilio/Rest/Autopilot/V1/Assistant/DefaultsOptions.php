<?php

namespace Twilio\Rest\Autopilot\V1\Assistant;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class DefaultsOptions
{
    public static function update(array $defaults = Values::ARRAY_NONE): UpdateDefaultsOptions
    {
        return new UpdateDefaultsOptions($defaults);
    }
}

class UpdateDefaultsOptions extends Options
{
    public function __construct(array $defaults = Values::ARRAY_NONE)
    {
        $this->options['defaults'] = $defaults;
    }

    public function setDefaults(array $defaults): self
    {
        $this->options['defaults'] = $defaults;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Autopilot.V1.UpdateDefaultsOptions ' . $options . ']';
    }
}