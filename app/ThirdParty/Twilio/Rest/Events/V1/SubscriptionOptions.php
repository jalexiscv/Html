<?php

namespace Twilio\Rest\Events\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SubscriptionOptions
{
    public static function read(string $sinkSid = Values::NONE): ReadSubscriptionOptions
    {
        return new ReadSubscriptionOptions($sinkSid);
    }

    public static function update(string $description = Values::NONE, string $sinkSid = Values::NONE): UpdateSubscriptionOptions
    {
        return new UpdateSubscriptionOptions($description, $sinkSid);
    }
}

class ReadSubscriptionOptions extends Options
{
    public function __construct(string $sinkSid = Values::NONE)
    {
        $this->options['sinkSid'] = $sinkSid;
    }

    public function setSinkSid(string $sinkSid): self
    {
        $this->options['sinkSid'] = $sinkSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Events.V1.ReadSubscriptionOptions ' . $options . ']';
    }
}

class UpdateSubscriptionOptions extends Options
{
    public function __construct(string $description = Values::NONE, string $sinkSid = Values::NONE)
    {
        $this->options['description'] = $description;
        $this->options['sinkSid'] = $sinkSid;
    }

    public function setDescription(string $description): self
    {
        $this->options['description'] = $description;
        return $this;
    }

    public function setSinkSid(string $sinkSid): self
    {
        $this->options['sinkSid'] = $sinkSid;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Events.V1.UpdateSubscriptionOptions ' . $options . ']';
    }
}