<?php

namespace Twilio\Rest\Events\V1\Subscription;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class SubscribedEventOptions
{
    public static function create(int $version = Values::NONE): CreateSubscribedEventOptions
    {
        return new CreateSubscribedEventOptions($version);
    }
}

class CreateSubscribedEventOptions extends Options
{
    public function __construct(int $version = Values::NONE)
    {
        $this->options['version'] = $version;
    }

    public function setVersion(int $version): self
    {
        $this->options['version'] = $version;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Events.V1.CreateSubscribedEventOptions ' . $options . ']';
    }
}