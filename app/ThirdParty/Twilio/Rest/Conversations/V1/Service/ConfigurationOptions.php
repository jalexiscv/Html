<?php

namespace Twilio\Rest\Conversations\V1\Service;

use Twilio\Options;
use Twilio\Values;
use function http_build_query;

abstract class ConfigurationOptions
{
    public static function update(string $defaultConversationCreatorRoleSid = Values::NONE, string $defaultConversationRoleSid = Values::NONE, string $defaultChatServiceRoleSid = Values::NONE, bool $reachabilityEnabled = Values::NONE): UpdateConfigurationOptions
    {
        return new UpdateConfigurationOptions($defaultConversationCreatorRoleSid, $defaultConversationRoleSid, $defaultChatServiceRoleSid, $reachabilityEnabled);
    }
}

class UpdateConfigurationOptions extends Options
{
    public function __construct(string $defaultConversationCreatorRoleSid = Values::NONE, string $defaultConversationRoleSid = Values::NONE, string $defaultChatServiceRoleSid = Values::NONE, bool $reachabilityEnabled = Values::NONE)
    {
        $this->options['defaultConversationCreatorRoleSid'] = $defaultConversationCreatorRoleSid;
        $this->options['defaultConversationRoleSid'] = $defaultConversationRoleSid;
        $this->options['defaultChatServiceRoleSid'] = $defaultChatServiceRoleSid;
        $this->options['reachabilityEnabled'] = $reachabilityEnabled;
    }

    public function setDefaultConversationCreatorRoleSid(string $defaultConversationCreatorRoleSid): self
    {
        $this->options['defaultConversationCreatorRoleSid'] = $defaultConversationCreatorRoleSid;
        return $this;
    }

    public function setDefaultConversationRoleSid(string $defaultConversationRoleSid): self
    {
        $this->options['defaultConversationRoleSid'] = $defaultConversationRoleSid;
        return $this;
    }

    public function setDefaultChatServiceRoleSid(string $defaultChatServiceRoleSid): self
    {
        $this->options['defaultChatServiceRoleSid'] = $defaultChatServiceRoleSid;
        return $this;
    }

    public function setReachabilityEnabled(bool $reachabilityEnabled): self
    {
        $this->options['reachabilityEnabled'] = $reachabilityEnabled;
        return $this;
    }

    public function __toString(): string
    {
        $options = http_build_query(Values::of($this->options), '', ' ');
        return '[Twilio.Conversations.V1.UpdateConfigurationOptions ' . $options . ']';
    }
}