<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Monitor\V1;
use Twilio\Rest\Monitor\V1\AlertContext;
use Twilio\Rest\Monitor\V1\AlertList;
use Twilio\Rest\Monitor\V1\EventContext;
use Twilio\Rest\Monitor\V1\EventList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Monitor extends Domain
{
    protected $_v1;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://monitor.twilio.com';
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

    protected function getAlerts(): AlertList
    {
        return $this->v1->alerts;
    }

    protected function contextAlerts(string $sid): AlertContext
    {
        return $this->v1->alerts($sid);
    }

    protected function getEvents(): EventList
    {
        return $this->v1->events;
    }

    protected function contextEvents(string $sid): EventContext
    {
        return $this->v1->events($sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Monitor]';
    }
}