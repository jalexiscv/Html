<?php

namespace Twilio\Rest\Events\V1\Subscription;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class SubscribedEventInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $subscriptionSid)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'type' => Values::array_get($payload, 'type'), 'version' => Values::array_get($payload, 'version'), 'subscriptionSid' => Values::array_get($payload, 'subscription_sid'), 'url' => Values::array_get($payload, 'url'),];
        $this->solution = ['subscriptionSid' => $subscriptionSid,];
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
        return '[Twilio.Events.V1.SubscribedEventInstance]';
    }
}