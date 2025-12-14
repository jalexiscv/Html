<?php

namespace Twilio\Rest;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\Rest\IpMessaging\V1;
use Twilio\Rest\IpMessaging\V2;
use Twilio\Rest\IpMessaging\V2\CredentialContext;
use Twilio\Rest\IpMessaging\V2\CredentialList;
use Twilio\Rest\IpMessaging\V2\ServiceContext;
use Twilio\Rest\IpMessaging\V2\ServiceList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class IpMessaging extends Domain
{
    protected $_v1;
    protected $_v2;

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->baseUrl = 'https://ip-messaging.twilio.com';
    }

    protected function getV1(): V1
    {
        if (!$this->_v1) {
            $this->_v1 = new V1($this);
        }
        return $this->_v1;
    }

    protected function getV2(): V2
    {
        if (!$this->_v2) {
            $this->_v2 = new V2($this);
        }
        return $this->_v2;
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

    protected function getCredentials(): CredentialList
    {
        return $this->v2->credentials;
    }

    protected function contextCredentials(string $sid): CredentialContext
    {
        return $this->v2->credentials($sid);
    }

    protected function getServices(): ServiceList
    {
        return $this->v2->services;
    }

    protected function contextServices(string $sid): ServiceContext
    {
        return $this->v2->services($sid);
    }

    public function __toString(): string
    {
        return '[Twilio.IpMessaging]';
    }
}