<?php

namespace Twilio\Rest\Conversations\V1\Conversation;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Conversations\V1\Conversation\Message\DeliveryReceiptContext;
use Twilio\Rest\Conversations\V1\Conversation\Message\DeliveryReceiptList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class MessageContext extends InstanceContext
{
    protected $_deliveryReceipts;

    public function __construct(Version $version, $conversationSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['conversationSid' => $conversationSid, 'sid' => $sid,];
        $this->uri = '/Conversations/' . rawurlencode($conversationSid) . '/Messages/' . rawurlencode($sid) . '';
    }

    public function update(array $options = []): MessageInstance
    {
        $options = new Values($options);
        $data = Values::of(['Author' => $options['author'], 'Body' => $options['body'], 'DateCreated' => Serialize::iso8601DateTime($options['dateCreated']), 'DateUpdated' => Serialize::iso8601DateTime($options['dateUpdated']), 'Attributes' => $options['attributes'],]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);
        return new MessageInstance($this->version, $payload, $this->solution['conversationSid'], $this->solution['sid']);
    }

    public function delete(array $options = []): bool
    {
        $options = new Values($options);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        return $this->version->delete('DELETE', $this->uri, [], [], $headers);
    }

    public function fetch(): MessageInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new MessageInstance($this->version, $payload, $this->solution['conversationSid'], $this->solution['sid']);
    }

    protected function getDeliveryReceipts(): DeliveryReceiptList
    {
        if (!$this->_deliveryReceipts) {
            $this->_deliveryReceipts = new DeliveryReceiptList($this->version, $this->solution['conversationSid'], $this->solution['sid']);
        }
        return $this->_deliveryReceipts;
    }

    public function __get(string $name): ListResource
    {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown subresource ' . $name);
    }

    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        throw new TwilioException('Resource does not have a context');
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Conversations.V1.MessageContext ' . implode(' ', $context) . ']';
    }
}