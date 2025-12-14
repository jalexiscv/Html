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

class WebhookInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $conversationSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'conversationSid' => Values::array_get($payload, 'conversation_sid'), 'target' => Values::array_get($payload, 'target'), 'url' => Values::array_get($payload, 'url'), 'configuration' => Values::array_get($payload, 'configuration'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),];
        $this->solution = ['conversationSid' => $conversationSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): WebhookContext
    {
        if (!$this->context) {
            $this->context = new WebhookContext($this->version, $this->solution['conversationSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): WebhookInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): WebhookInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
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
        return '[Twilio.Conversations.V1.WebhookInstance ' . implode(' ', $context) . ']';
    }
}