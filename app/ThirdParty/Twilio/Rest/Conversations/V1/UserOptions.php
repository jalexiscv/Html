<?php

namespace Twilio\Rest\Conversations\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class UserOptions
{
    public static function create(string $friendlyName = Values::NONE, string $attributes = Values::NONE, string $roleSid = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): CreateUserOptions
    {
        return new CreateUserOptions($friendlyName, $attributes, $roleSid, $xTwilioWebhookEnabled);
    }

    public static function update(string $friendlyName = Values::NONE, string $attributes = Values::NONE, string $roleSid = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE): UpdateUserOptions
    {
        return new UpdateUserOptions($friendlyName, $attributes, $roleSid, $xTwilioWebhookEnabled);
    }

    public static function delete(string $xTwilioWebhookEnabled = Values::NONE): DeleteUserOptions
    {
        return new DeleteUserOptions($xTwilioWebhookEnabled);
    }
}

class CreateUserOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $attributes = Values::NONE, string $roleSid = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['attributes'] = $attributes;
        $this->options['roleSid'] = $roleSid;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function setRoleSid(string $roleSid): self
    {
        $this->options['roleSid'] = $roleSid;
        return $this;
    }

    public function setXTwilioWebhookEnabled(string $xTwilioWebhookEnabled): self
    {
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Conversations.V1.CreateUserOptions ' . $options . ']';
    }
}

class UpdateUserOptions extends Options
{
    public function __construct(string $friendlyName = Values::NONE, string $attributes = Values::NONE, string $roleSid = Values::NONE, string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['attributes'] = $attributes;
        $this->options['roleSid'] = $roleSid;
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setFriendlyName(string $friendlyName): self
    {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    public function setAttributes(string $attributes): self
    {
        $this->options['attributes'] = $attributes;
        return $this;
    }

    public function setRoleSid(string $roleSid): self
    {
        $this->options['roleSid'] = $roleSid;
        return $this;
    }

    public function setXTwilioWebhookEnabled(string $xTwilioWebhookEnabled): self
    {
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Conversations.V1.UpdateUserOptions ' . $options . ']';
    }
}

class DeleteUserOptions extends Options
{
    public function __construct(string $xTwilioWebhookEnabled = Values::NONE)
    {
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
    }

    public function setXTwilioWebhookEnabled(string $xTwilioWebhookEnabled): self
    {
        $this->options['xTwilioWebhookEnabled'] = $xTwilioWebhookEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Conversations.V1.DeleteUserOptions ' . $options . ']';
    }
}