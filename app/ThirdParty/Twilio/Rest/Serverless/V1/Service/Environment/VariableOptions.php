<?php

namespace Twilio\Rest\Serverless\V1\Service\Environment;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class VariableOptions
{
    public static function update(string $key = Values::NONE, string $value = Values::NONE): UpdateVariableOptions
    {
        return new UpdateVariableOptions($key, $value);
    }
}

class UpdateVariableOptions extends Options
{
    public function __construct(string $key = Values::NONE, string $value = Values::NONE)
    {
        $this->options['key'] = $key;
        $this->options['value'] = $value;
    }

    public function setKey(string $key): self
    {
        $this->options['key'] = $key;
        return $this;
    }

    public function setValue(string $value): self
    {
        $this->options['value'] = $value;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Serverless.V1.UpdateVariableOptions ' . $options . ']';
    }
}