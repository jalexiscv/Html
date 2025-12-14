<?php

namespace Twilio\Rest\Conversations\V1\Service\Conversation;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Conversations\V1\Service\Conversation\Message\DeliveryReceiptList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class MessageInstance extends InstanceResource
{
    protected $_deliveryReceipts;

    public function __construct(Version $version, array $payload, string $chatServiceSid, string $conversationSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'chatServiceSid' => Values::array_get($payload, 'chat_service_sid'), 'conversationSid' => Values::array_get($payload, 'conversation_sid'), 'sid' => Values::array_get($payload, 'sid'), 'index' => Values::array_get($payload, 'index'), 'author' => Values::array_get($payload, 'author'), 'body' => Values::array_get($payload, 'body'), 'media' => Values::array_get($payload, 'media'), 'attributes' => Values::array_get($payload, 'attributes'), 'participantSid' => Values::array_get($payload, 'participant_sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'delivery' => Values::array_get($payload, 'delivery'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['chatServiceSid' => $chatServiceSid, 'conversationSid' => $conversationSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): MessageContext
    {
        if (!$this->context) {
            $this->context = new MessageContext($this->version, $this->solution['chatServiceSid'], $this->solution['conversationSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function update(array $options = []): MessageInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(array $options = []): bool
    {
        return $this->proxy()->delete($options);
    }

    public function fetch(): MessageInstance
    {
        return $this->proxy()->fetch();
    }

    protected function getDeliveryReceipts(): DeliveryReceiptList
    {
        return $this->proxy()->deliveryReceipts;
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
        return '[Twilio.Conversations.V1.MessageInstance ' . implode(' ', $context) . ']';
    }
}