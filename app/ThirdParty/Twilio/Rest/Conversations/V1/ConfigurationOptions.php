<?php

namespace Twilio\Rest\Conversations\V1;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ConfigurationOptions
{
    public static function update(string $defaultChatServiceSid = Values::NONE, string $defaultMessagingServiceSid = Values::NONE, string $defaultInactiveTimer = Values::NONE, string $defaultClosedTimer = Values::NONE): UpdateConfigurationOptions
    {
        return new UpdateConfigurationOptions($defaultChatServiceSid, $defaultMessagingServiceSid, $defaultInactiveTimer, $defaultClosedTimer);
    }
}

class UpdateConfigurationOptions extends Options
{
    public function __construct(string $defaultChatServiceSid = Values::NONE, string $defaultMessagingServiceSid = Values::NONE, string $defaultInactiveTimer = Values::NONE, string $defaultClosedTimer = Values::NONE)
    {
        $this->options['defaultChatServiceSid'] = $defaultChatServiceSid;
        $this->options['defaultMessagingServiceSid'] = $defaultMessagingServiceSid;
        $this->options['defaultInactiveTimer'] = $defaultInactiveTimer;
        $this->options['defaultClosedTimer'] = $defaultClosedTimer;
    }

    public function setDefaultChatServiceSid(string $defaultChatServiceSid): self
    {
        $this->options['defaultChatServiceSid'] = $defaultChatServiceSid;
        return $this;
    }

    public function setDefaultMessagingServiceSid(string $defaultMessagingServiceSid): self
    {
        $this->options['defaultMessagingServiceSid'] = $defaultMessagingServiceSid;
        return $this;
    }

    public function setDefaultInactiveTimer(string $defaultInactiveTimer): self
    {
        $this->options['defaultInactiveTimer'] = $defaultInactiveTimer;
        return $this;
    }

    public function setDefaultClosedTimer(string $defaultClosedTimer): self
    {
        $this->options['defaultClosedTimer'] = $defaultClosedTimer;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Conversations.V1.UpdateConfigurationOptions ' . $options . ']';
    }
}