<?php

namespace Twilio\Rest\Voice\V1\ConnectionPolicy;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ConnectionPolicyTargetOptions
{
    public static function create(string $friendlyName = Values::NONE, int $priority = Values::NONE, int $weight = Values::NONE, bool $enabled = Values::NONE): CreateConnectionPolicyTargetOptions
    {
        return new CreateConnectionPolicyTargetOptions($friendlyName, $priority, $weight, $enabled);
    }

    public static function update(string $friendlyName = Values::NONE, string $target = Values::NONE, int $priority = Values::NONE, int $weight = Values::NONE, bool $enabled = Values::NONE): UpdateConnectionPolicyTargetOptions
    {
        return new UpdateConnectionPolicyTargetOptions($friendlyName, $target, $priority, $weight, $enabled);
    }
}

class CreateConnectionPolicyTargetOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, int $priority = Values::NONE, int $weight = Values::NONE, bool $enabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['priority'] = $priority;
        $this->options['weight'] = $weight;
        $this->options['enabled'] = $enabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setPriority(int $priority): self
    {
        $this->options['priority'] = $priority;
        return $this;
    }

    public function setWeight(int $weight): self
    {
        $this->options['weight'] = $weight;
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
        return '[Twilio.Voice.V1.CreateConnectionPolicyTargetOptions ' . $options . ']';
    }
}

class UpdateConnectionPolicyTargetOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $target = Values::NONE, int $priority = Values::NONE, int $weight = Values::NONE, bool $enabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['target'] = $target;
        $this->options['priority'] = $priority;
        $this->options['weight'] = $weight;
        $this->options['enabled'] = $enabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setTarget(string $target): self
    {
        $this->options['target'] = $target;
        return $this;
    }

    public function setPriority(int $priority): self
    {
        $this->options['priority'] = $priority;
        return $this;
    }

    public function setWeight(int $weight): self
    {
        $this->options['weight'] = $weight;
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
        return '[Twilio.Voice.V1.UpdateConnectionPolicyTargetOptions ' . $options . ']';
    }
}