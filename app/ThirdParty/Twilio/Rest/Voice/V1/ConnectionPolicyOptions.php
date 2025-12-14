<?php

namespace Twilio\Rest\Voice\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ConnectionPolicyOptions
{
    public static function create(string $friendlyName = Values::NONE): CreateConnectionPolicyOptions
    {
        return new CreateConnectionPolicyOptions($friendlyName);
    }

    public static function update(string $friendlyName = Values::NONE): UpdateConnectionPolicyOptions
    {
        return new UpdateConnectionPolicyOptions($friendlyName);
    }
}

class CreateConnectionPolicyOptions extends Options
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
        return '[Twilio.Voice.V1.CreateConnectionPolicyOptions ' . $options . ']';
    }
}

class UpdateConnectionPolicyOptions extends Options
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
        return '[Twilio.Voice.V1.UpdateConnectionPolicyOptions ' . $options . ']';
    }
}