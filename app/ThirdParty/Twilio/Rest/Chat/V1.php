<?php

namespace Twilio\Rest\Chat;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Chat\V1\CredentialContext;
use Twilio\Rest\Chat\V1\CredentialList;
use Twilio\Rest\Chat\V1\ServiceContext;
use Twilio\Rest\Chat\V1\ServiceList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class V1 extends Version
{
    protected $_credentials;
    protected $_services;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'v1';
    }

    protected function getCredentials(): CredentialList
    {
        if (!$this->_credentials) {
            $this->_credentials = new CredentialList($this);
        }
        return $this->_credentials;
    }

    protected function getServices(): ServiceList
    {
        if (!$this->_services) {
            $this->_services = new ServiceList($this);
        }
        return $this->_services;
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
        return '[Twilio.Chat.V1]';
    }
}