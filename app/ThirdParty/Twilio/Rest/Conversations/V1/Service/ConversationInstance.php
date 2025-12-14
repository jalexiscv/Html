<?php

namespace Twilio\Rest\Conversations\V1\Service;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Conversations\V1\Service\Conversation\MessageList;
use Twilio\Rest\Conversations\V1\Service\Conversation\ParticipantList;
use Twilio\Rest\Conversations\V1\Service\Conversation\WebhookList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ConversationInstance extends InstanceResource
{
    protected $_participants;
    protected $_messages;
    protected $_webhooks;

    public function __construct(Version $version, array $payload, string $chatServiceSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'chatServiceSid' => Values::array_get($payload, 'chat_service_sid'), 'messagingServiceSid' => Values::array_get($payload, 'messaging_service_sid'), 'sid' => Values::array_get($payload, 'sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'uniqueName' => Values::array_get($payload, 'unique_name'), 'attributes' => Values::array_get($payload, 'attributes'), 'state' => Values::array_get($payload, 'state'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'timers' => Values::array_get($payload, 'timers'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['chatServiceSid' => $chatServiceSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ConversationContext
    {
        if (!$this->context) {
            $this->context = new ConversationContext($this->version, $this->solution['chatServiceSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function update(array $options = []): ConversationInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(array $options = []): bool
    {
        return $this->proxy()->delete($options);
    }

    public function fetch(): ConversationInstance
    {
        return $this->proxy()->fetch();
    }

    protected function getParticipants(): ParticipantList
    {
        return $this->proxy()->participants;
    }

    protected function getMessages(): MessageList
    {
        return $this->proxy()->messages;
    }

    protected function getWebhooks(): WebhookList
    {
        return $this->proxy()->webhooks;
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
        return '[Twilio.Conversations.V1.ConversationInstance ' . implode(' ', $context) . ']';
    }
}