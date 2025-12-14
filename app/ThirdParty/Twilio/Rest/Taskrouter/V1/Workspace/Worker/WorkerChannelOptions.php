<?php

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class WorkerChannelOptions
{
    public static function update(int $capacity = Values::NONE, bool $available = Values::NONE): UpdateWorkerChannelOptions
    {
        return new UpdateWorkerChannelOptions($capacity, $available);
    }
}

class UpdateWorkerChannelOptions extends Options
{
    public function __construct(int $capacity = Values::NONE, bool $available = Values::NONE)
    {
        $this->options['capacity'] = $capacity;
        $this->options['available'] = $available;
    }

    public function setCapacity(int $capacity): self
    {
        $this->options['capacity'] = $capacity;
        return $this;
    }

    public function setAvailable(bool $available): self
    {
        $this->options['available'] = $available;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Taskrouter.V1.UpdateWorkerChannelOptions ' . $options . ']';
    }
}