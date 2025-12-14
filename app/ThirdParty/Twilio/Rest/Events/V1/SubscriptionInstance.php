<?php

namespace Twilio\Rest\Events\V1;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Events\V1\Subscription\SubscribedEventList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class SubscriptionInstance extends InstanceResource
{
    protected $_subscribedEvents;

    public function __construct(Version $version, array $payload, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'sid' => Values::array_get($payload, 'sid'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'description' => Values::array_get($payload, 'description'), 'sinkSid' => Values::array_get($payload, 'sink_sid'), 'url' => Values::array_get($payload, 'url'), 'links' => Values::array_get($payload, 'links'),];
        $this->solution = ['sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): SubscriptionContext
    {
        if (!$this->context) {
            $this->context = new SubscriptionContext($this->version, $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): SubscriptionInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): SubscriptionInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getSubscribedEvents(): SubscribedEventList
    {
        return $this->proxy()->subscribedEvents;
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
        return '[Twilio.Events.V1.SubscriptionInstance ' . implode(' ', $context) . ']';
    }
}