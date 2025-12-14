<?php

namespace Twilio\Rest\Monitor;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Monitor\V1\AlertContext;
use Twilio\Rest\Monitor\V1\AlertList;
use Twilio\Rest\Monitor\V1\EventContext;
use Twilio\Rest\Monitor\V1\EventList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_alerts;
    protected $_events;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getAlerts(): AlertList
    {
        if (!$this->_alerts) {
            $this->_alerts = new AlertList($this);
        }
        return $this->_alerts;
    }

    protected function getEvents(): EventList
    {
        if (!$this->_events) {
            $this->_events = new EventList($this);
        }
        return $this->_events;
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
        return '[Twilio.Monitor.V1]';
    }
}