<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\Messaging\V1;
use Twilio\Rest\Messaging\V1\DeactivationsContext;
use Twilio\Rest\Messaging\V1\DeactivationsList;
use Twilio\Rest\Messaging\V1\ServiceContext;
use Twilio\Rest\Messaging\V1\ServiceList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class Messaging extends Domain
{
    protected $_v1;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://messaging.twilio.com';
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

    protected function getDeactivations(): DeactivationsList
    {
        return $this->v1->deactivations;
    }

    protected function contextDeactivations(): DeactivationsContext
    {
        return $this->v1->deactivations();
    }

    protected function getServices(): ServiceList
    {
        return $this->v1->services;
    }

    protected function contextServices(string $sid): ServiceContext
    {
        return $this->v1->services($sid);
    }

    public function __toString(): string
    {
        return '[Twilio.Messaging]';
    }
}