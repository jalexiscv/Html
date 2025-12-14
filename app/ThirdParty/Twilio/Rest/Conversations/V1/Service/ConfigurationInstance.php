<?php

namespace Twilio\Rest\Conversations\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ConfigurationInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $chatServiceSid)
    {
        parent::__construct($version);
        $this->properties = ['chatServiceSid' => Values::array_get($payload, 'chat_service_sid'), 'defaultConversationCreatorRoleSid' => Values::array_get($payload, 'default_conversation_creator_role_sid'), 'defaultConversationRoleSid' => Values::array_get($payload, 'default_conversation_role_sid'), 'defaultChatServiceRoleSid' => Values::array_get($payload, 'default_chat_service_role_sid'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'), 'reachabilityEnabled' => Values::array_get($payload, 'reachability_enabled'),];
        $this->solution = ['chatServiceSid' => $chatServiceSid,];
    }

    protected function proxy(): ConfigurationContext
    {
        if (!$this->context) {
            $this->context = new ConfigurationContext($this->version, $this->solution['chatServiceSid']);
        }
        return $this->context;
    }

    public function fetch(): ConfigurationInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): ConfigurationInstance
    {
        return $this->proxy()->update($options);
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Conversations.V1.ConfigurationInstance ' . implode(' ', $context) . ']';
    }
}