<?php

namespace Twilio\Rest\Conversations\V1\Service\Configuration;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class NotificationInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $chatServiceSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'chatServiceSid' => Values::array_get($payload, 'chat_service_sid'), 'newMessage' => Values::array_get($payload, 'new_message'), 'addedToConversation' => Values::array_get($payload, 'added_to_conversation'), 'removedFromConversation' => Values::array_get($payload, 'removed_from_conversation'), 'logEnabled' => Values::array_get($payload, 'log_enabled'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['chatServiceSid' => $chatServiceSid,];
    }

    protected function proxy(): NotificationContext
    {
        if (!$this->context) {
            $this->context = new NotificationContext($this->version, $this->solution['chatServiceSid']);
        }
        return $this->context;
    }

    public function update(array $options = []): NotificationInstance
    {
        return $this->proxy()->update($options);
    }

    public function fetch(): NotificationInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Conversations.V1.NotificationInstance ' . implode(' ', $context) . ']';
    }
}