<?php

namespace Twilio\Rest\Conversations\V1;

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
    public function __construct(Version $version, array $payload)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'defaultChatServiceSid' => Values::array_get($payload, 'default_chat_service_sid'), 'defaultMessagingServiceSid' => Values::array_get($payload, 'default_messaging_service_sid'), 'defaultInactiveTimer' => Values::array_get($payload, 'default_inactive_timer'), 'defaultClosedTimer' => Values::array_get($payload, 'default_closed_timer'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = [];
    }

    protected function proxy(): ConfigurationContext
    {
        if (!$this->context) {
            $this->context = new ConfigurationContext($this->version);
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