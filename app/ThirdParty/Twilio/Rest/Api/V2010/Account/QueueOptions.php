<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class QueueOptions
{
    public static function update(string $friendlyName = Values::NONE, int $maxSize = Values::NONE): UpdateQueueOptions
    {
        return new UpdateQueueOptions($friendlyName, $maxSize);
    }

    public static function create(int $maxSize = Values::NONE): CreateQueueOptions
    {
        return new CreateQueueOptions($maxSize);
    }
}

class UpdateQueueOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, int $maxSize = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['maxSize'] = $maxSize;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setMaxSize(int $maxSize): self
    {
        $this->options['maxSize'] = $maxSize;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.UpdateQueueOptions ' . $options . ']';
    }
}

class CreateQueueOptions extends Options
{
    public function __construct(int $maxSize = Values::NONE)
    {
        $this->options['maxSize'] = $maxSize;
    }

    public function setMaxSize(int $maxSize): self
    {
        $this->options['maxSize'] = $maxSize;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Api.V2010.CreateQueueOptions ' . $options . ']';
    }
}