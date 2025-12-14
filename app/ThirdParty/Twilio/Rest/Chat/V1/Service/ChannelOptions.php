<?php

namespace Twilio\Rest\Chat\V1\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ChannelOptions
{
    public static function create(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, string $attributes = Values::NONE, string $type = Values::NONE): CreateChannelOptions
    {
        return new CreateChannelOptions($friendlyName, $uniqueName, $attributes, $type);
    }

    public static function read(array $type = Values::ARRAY_NONE): ReadChannelOptions
    {
        return new ReadChannelOptions($type);
    }

    public static function update(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, string $attributes = Values::NONE): UpdateChannelOptions
    {
        return new UpdateChannelOptions($friendlyName, $uniqueName, $attributes);
    }
}

class CreateChannelOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, string $attributes = Values::NONE, string $type = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['attributes'] = $attributes;
        $this->options['type'] = $type;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function setType(string $type): self
    {
        $this->options['type'] = $type;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V1.CreateChannelOptions ' . $options . ']';
    }
}

class ReadChannelOptions extends Options
{
    public function __construct(array $type = Values::ARRAY_NONE)
    {
        $this->options['type'] = $type;
    }

    public function setType(array $type): self
    {
        $this->options['type'] = $type;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Chat.V1.ReadChannelOptions ' . $options . ']';
    }
}

class UpdateChannelOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $uniqueName = Values::NONE, string $attributes = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['uniqueName'] = $uniqueName;
        $this->options['attributes'] = $attributes;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->options['uniqueName'] = $uniqueName;
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
        return '[Twilio.Chat.V1.UpdateChannelOptions ' . $options . ']';
    }
}