<?php

namespace Twilio\Rest\Conversations\V1\Conversation\Message;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class DeliveryReceiptInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $conversationSid, string $messageSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'conversationSid' => Values::array_get($payload, 'conversation_sid'), 'sid' => Values::array_get($payload, 'sid'), 'messageSid' => Values::array_get($payload, 'message_sid'), 'channelMessageSid' => Values::array_get($payload, 'channel_message_sid'), 'participantSid' => Values::array_get($payload, 'participant_sid'), 'status' => Values::array_get($payload, 'status'), 'errorCode' => Values::array_get($payload, 'error_code'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['conversationSid' => $conversationSid, 'messageSid' => $messageSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): DeliveryReceiptContext
    {
        if (!$this->context) {
            $this->context = new DeliveryReceiptContext($this->version, $this->solution['conversationSid'], $this->solution['messageSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): DeliveryReceiptInstance
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
        return '[Twilio.Conversations.V1.DeliveryReceiptInstance ' . implode(' ', $context) . ']';
    }
}