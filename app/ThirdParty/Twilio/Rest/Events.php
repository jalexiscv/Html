<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Events\V1;
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

class Events extends Domain
{
    protected $_v1;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://events.twilio.com';
    }

    protected function getV1(): V1
    {
        if (!$this->_v1) {
            $this->_v1 = new V1($this);
        }
        return $this->_v1;
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        throw new TwilioException('Unknown version ' . $name);
    }

    public function __call(string $name, array $arguments)
    {
        $method = 'context' . ucfirst($name);
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }
        throw new TwilioException('Unknown context ' . $name);
    }

    protected function getEventTypes(): EventTypeList
    {
        return $this->v1->eventTypes;
    }

    protected function contextEventTypes(string $type): EventTypeContext
    {
        return $this->v1->eventTypes($type);
    }

    protected function getSchemas(): SchemaList
    {
        return $this->v1->schemas;
    }

    protected function contextSchemas(string $id): SchemaContext
    {
        return $this->v1->schemas($id);
    }

    protected function getSinks(): SinkList
    {
        return $this->v1->sinks;
    }

    protected function contextSinks(string $sid): SinkContext
    {
        return $this->v1->sinks($sid);
    }

    protected function getSubscriptions(): SubscriptionList
    {
        return $this->v1->subscriptions;
    }

    protected function contextSubscriptions(string $sid): SubscriptionContext
    {
        return $this->v1->subscriptions($sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Events]';
    }
}