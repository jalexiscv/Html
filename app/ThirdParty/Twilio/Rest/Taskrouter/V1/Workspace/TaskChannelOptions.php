<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class TaskChannelOptions
{
    public static function update(string $friendlyName = Values::NONE, bool $channelOptimizedRouting = Values::NONE): UpdateTaskChannelOptions
    {
        return new UpdateTaskChannelOptions($friendlyName, $channelOptimizedRouting);
    }

    public static function create(bool $channelOptimizedRouting = Values::NONE): CreateTaskChannelOptions
    {
        return new CreateTaskChannelOptions($channelOptimizedRouting);
    }
}

class UpdateTaskChannelOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, bool $channelOptimizedRouting = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['channelOptimizedRouting'] = $channelOptimizedRouting;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setChannelOptimizedRouting(bool $channelOptimizedRouting): self
    {
        $this->options['channelOptimizedRouting'] = $channelOptimizedRouting;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.UpdateTaskChannelOptions ' . $options . ']';
    }
}

class CreateTaskChannelOptions extends Options
{
    public function __construct(bool $channelOptimizedRouting = Values::NONE)
    {
        $this->options['channelOptimizedRouting'] = $channelOptimizedRouting;
    }

    public function setChannelOptimizedRouting(bool $channelOptimizedRouting): self
    {
        $this->options['channelOptimizedRouting'] = $channelOptimizedRouting;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.CreateTaskChannelOptions ' . $options . ']';
    }
}