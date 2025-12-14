<?php

namespace Twilio\Rest\Chat\V1\Service\Channel;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class MessageOptions
{
    public static function create(string $from = Values::NONE, string $attributes = Values::NONE): CreateMessageOptions
    {
        return new CreateMessageOptions($from, $attributes);
    }

    public static function read(string $order = Values::NONE): ReadMessageOptions
    {
        return new ReadMessageOptions($order);
    }

    public static function update(string $body = Values::NONE, string $attributes = Values::NONE): UpdateMessageOptions
    {
        return new UpdateMessageOptions($body, $attributes);
    }
}

class CreateMessageOptions extends Options
{
    public function __construct(string $from = Values::NONE, string $attributes = Values::NONE)
    {
        $this->options['from'] = $from;
        $this->options['attributes'] = $attributes;
    }

    public function setFrom(string $from): self
    {
        $this->options['from'] = $from;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V1.CreateMessageOptions ' . $options . ']';
    }
}

class ReadMessageOptions extends Options
{
    public function __construct(string $order = Values::NONE)
    {
        $this->options['order'] = $order;
    }

    public function setOrder(string $order): self
    {
        $this->options['order'] = $order;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V1.ReadMessageOptions ' . $options . ']';
    }
}

class UpdateMessageOptions extends Options
{
    public function __construct(string $body = Values::NONE, string $attributes = Values::NONE)
    {
        $this->options['body'] = $body;
        $this->options['attributes'] = $attributes;
    }

    public function setBody(string $body): self
    {
        $this->options['body'] = $body;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V1.UpdateMessageOptions ' . $options . ']';
    }
}