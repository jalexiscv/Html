<?php

namespace Twilio\Rest\Proxy\V1\Service\Session\Participant;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class MessageInteractionOptions
{
    public static function create(string $body = Values::NONE, array $mediaUrl = Values::ARRAY_NONE): CreateMessageInteractionOptions
    {
        return new CreateMessageInteractionOptions($body, $mediaUrl);
    }
}

class CreateMessageInteractionOptions extends Options
{
    public function __construct(string $body = Values::NONE, array $mediaUrl = Values::ARRAY_NONE)
    {
        $this->options['body'] = $body;
        $this->options['mediaUrl'] = $mediaUrl;
    }

    public function setBody(string $body): self
    {
        $this->options['body'] = $body;
        return $this;
    }

    public function setMediaUrl(array $mediaUrl): self
    {
        $this->options['mediaUrl'] = $mediaUrl;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Proxy.V1.CreateMessageInteractionOptions ' . $options . ']';
    }
}