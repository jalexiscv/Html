<?php

namespace Twilio\Rest\IpMessaging\V1\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class UserOptions
{
    public static function create(string $roleSid = Values::NONE, string $attributes = Values::NONE, string $friendlyName = Values::NONE): CreateUserOptions
    {
        return new CreateUserOptions($roleSid, $attributes, $friendlyName);
    }

    public static function update(string $roleSid = Values::NONE, string $attributes = Values::NONE, string $friendlyName = Values::NONE): UpdateUserOptions
    {
        return new UpdateUserOptions($roleSid, $attributes, $friendlyName);
    }
}

class CreateUserOptions extends Options
{
    public function __construct(string $roleSid = Values::NONE, string $attributes = Values::NONE, string $friendlyName = Values::NONE)
    {
        $this->options['roleSid'] = $roleSid;
        $this->options['attributes'] = $attributes;
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setRoleSid(string $roleSid): self
    {
        $this->options['roleSid'] = $roleSid;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.IpMessaging.V1.CreateUserOptions ' . $options . ']';
    }
}

class UpdateUserOptions extends Options
{
    public function __construct(string $roleSid = Values::NONE, string $attributes = Values::NONE, string $friendlyName = Values::NONE)
    {
        $this->options['roleSid'] = $roleSid;
        $this->options['attributes'] = $attributes;
        $this->options['friendlyName'] = $friendlyName;
    }

    public function setRoleSid(string $roleSid): self
    {
        $this->options['roleSid'] = $roleSid;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.IpMessaging.V1.UpdateUserOptions ' . $options . ']';
    }
}