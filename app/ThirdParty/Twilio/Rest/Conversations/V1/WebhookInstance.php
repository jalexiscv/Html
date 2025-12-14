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

class WebhookInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'method' => Values::array_get($payload, 'method'), 'filters' => Values::array_get($payload, 'filters'), 'preWebhookUrl' => Values::array_get($payload, 'pre_webhook_url'), 'postWebhookUrl' => Values::array_get($payload, 'post_webhook_url'), 'target' => Values::array_get($payload, 'target'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = [];
    }

    protected function proxy(): WebhookContext
    {
        if (!$this->context) {
            $this->context = new WebhookContext($this->version);
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