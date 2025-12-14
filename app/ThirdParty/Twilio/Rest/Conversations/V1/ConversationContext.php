<?php

namespace Twilio\Rest\Conversations\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Conversations\V1\Conversation\MessageContext;
use Twilio\Rest\Conversations\V1\Conversation\MessageList;
use Twilio\Rest\Conversations\V1\Conversation\ParticipantContext;
use Twilio\Rest\Conversations\V1\Conversation\ParticipantList;
use Twilio\Rest\Conversations\V1\Conversation\WebhookList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class ConversationContext extends InstanceContext
{
    protected $_participants;
    protected $_messages;
    protected $_webhooks;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Conversations/' . rawurlencode($sid) . '';
    }

    public function update(array $options = []): ConversationInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'DateCreated' => Serialize::iso8601DateTime($options['dateCreated']), 'DateUpdated' => Serialize::iso8601DateTime($options['dateUpdated']), 'Attributes' => $options['attributes'], 'MessagingServiceSid' => $options['messagingServiceSid'], 'State' => $options['state'], 'Timers.Inactive' => $options['timersInactive'], 'Timers.Closed' => $options['timersClosed'], 'UniqueName' => $options['uniqueName'],]);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data, $headers);
        return new ConversationInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(array $options = []): bool
    {
        $options = new Values($options);
        $headers = Values::of(['X-Twilio-Webhook-Enabled' => $options['xTwilioWebhookEnabled'],]);
        return $this->version->delete('DELETE', $this->uri, [], [], $headers);
    }

    public function fetch(): ConversationInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new ConversationInstance($this->version, $payload, $this->solution['sid']);
    }

    protected function getParticipants(): ParticipantList
    {
        if (!$this->_participants) {
            $this->_participants = new ParticipantList($this->version, $this->solution['sid']);
        }
        return $this->_participants;
    }

    protected function getMessages(): MessageList
    {
        if (!$this->_messages) {
            $this->_messages = new MessageList($this->version, $this->solution['sid']);
        }
        return $this->_messages;
    }

    protected function getWebhooks(): WebhookList
    {
        if (!$this->_webhooks) {
            $this->_webhooks = new WebhookList($this->version, $this->solution['sid']);
        }
        return $this->_webhooks;
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
        return '[Twilio.Conversations.V1.ConversationContext ' . implode(' ', $context) . ']';
    }
}