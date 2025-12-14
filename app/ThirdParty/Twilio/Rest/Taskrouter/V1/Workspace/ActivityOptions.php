<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ActivityOptions
{
    public static function update(string $friendlyName = Values::NONE): UpdateActivityOptions
    {
        return new UpdateActivityOptions($friendlyName);
    }

    public static function read(string $friendlyName = Values::NONE, string $available = Values::NONE): ReadActivityOptions
    {
        return new ReadActivityOptions($friendlyName, $available);
    }

    public static function create(bool $available = Values::NONE): CreateActivityOptions
    {
        return new CreateActivityOptions($available);
    }
}

class UpdateActivityOptions extends Options
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
        return '[Twilio.Taskrouter.V1.UpdateActivityOptions ' . $options . ']';
    }
}

class ReadActivityOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $available = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['available'] = $available;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setAvailable(string $available): self
    {
        $this->options['available'] = $available;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.ReadActivityOptions ' . $options . ']';
    }
}

class CreateActivityOptions extends Options
{
    public function __construct(bool $available = Values::NONE)
    {
        $this->options['available'] = $available;
    }

    public function setAvailable(bool $available): self
    {
        $this->options['available'] = $available;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.CreateActivityOptions ' . $options . ']';
    }
}