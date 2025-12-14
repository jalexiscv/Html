<?php

namespace Twilio\Rest\Conversations\V1\Conversation;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class ParticipantInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $conversationSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'conversationSid' => Values::array_get($payload, 'conversation_sid'), 'sid' => Values::array_get($payload, 'sid'), 'identity' => Values::array_get($payload, 'identity'), 'attributes' => Values::array_get($payload, 'attributes'), 'messagingBinding' => Values::array_get($payload, 'messaging_binding'), 'roleSid' => Values::array_get($payload, 'role_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'), 'lastReadMessageIndex' => Values::array_get($payload, 'last_read_message_index'), 'lastReadTimestamp' => Values::array_get($payload, 'last_read_timestamp'),];
        $this->solution = ['conversationSid' => $conversationSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): ParticipantContext
    {
        if (!$this->context) {
            $this->context = new ParticipantContext($this->version, $this->solution['conversationSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function update(array $options = []): ParticipantInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(array $options = []): bool
    {
        return $this->proxy()->delete($options);
    }

    public function fetch(): ParticipantInstance
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
        return '[Twilio.Conversations.V1.ParticipantInstance ' . implode(' ', $context) . ']';
    }
}