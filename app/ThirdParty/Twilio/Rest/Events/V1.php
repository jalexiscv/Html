<?php

namespace Twilio\Rest\Events;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Events\V1\EventTypeContext;
use Twilio\Rest\Events\V1\EventTypeList;
use Twilio\Rest\Events\V1\SchemaContext;
use Twilio\Rest\Events\V1\SchemaList;
use Twilio\Rest\Events\V1\SinkContext;
use Twilio\Rest\Events\V1\SinkList;
use Twilio\Rest\Events\V1\SubscriptionContext;
use Twilio\Rest\Events\V1\SubscriptionList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_eventTypes;
    protected $_schemas;
    protected $_sinks;
    protected $_subscriptions;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getEventTypes(): EventTypeList
    {
        if (!$this->_eventTypes) {
            $this->_eventTypes = new EventTypeList($this);
        }
        return $this->_eventTypes;
    }

    protected function getSchemas(): SchemaList
    {
        if (!$this->_schemas) {
            $this->_schemas = new SchemaList($this);
        }
        return $this->_schemas;
    }

    protected function getSinks(): SinkList
    {
        if (!$this->_sinks) {
            $this->_sinks = new SinkList($this);
        }
        return $this->_sinks;
    }

    protected function getSubscriptions(): SubscriptionList
    {
        if (!$this->_subscriptions) {
            $this->_subscriptions = new SubscriptionList($this);
        }
        return $this->_subscriptions;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown resource ' . $name);
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
        return '[Twilio.Events.V1]';
    }
}