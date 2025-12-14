<?php

namespace Twilio\Rest\Events\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Events\V1\Subscription\SubscribedEventList;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class SubscriptionContext extends InstanceContext
{
    protected $_subscribedEvents;

    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);
        $this->solution = ['sid' => $sid,];
        $this->uri = '/Subscriptions/' . rawurlencode($sid) . '';
    }

    public function fetch(): SubscriptionInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new SubscriptionInstance($this->version, $payload, $this->solution['sid']);
    }

    public function update(array $options = []): SubscriptionInstance
    {
        $options = new Values($options);
        $data = Values::of(['Description' => $options['description'], 'SinkSid' => $options['sinkSid'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new SubscriptionInstance($this->version, $payload, $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getSubscribedEvents(): SubscribedEventList
    {
        if (!$this->_subscribedEvents) {
            $this->_subscribedEvents = new SubscribedEventList($this->version, $this->solution['sid']);
        }
        return $this->_subscribedEvents;
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
        return '[Twilio.Events.V1.SubscriptionContext ' . implode(' ', $context) . ']';
    }
}