<?php

namespace Twilio\Rest\Preview;

use Twilio\Domain;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Preview\HostedNumbers\AuthorizationDocumentContext;
use Twilio\Rest\Preview\HostedNumbers\AuthorizationDocumentList;
use Twilio\Rest\Preview\HostedNumbers\HostedNumberOrderContext;
use Twilio\Rest\Preview\HostedNumbers\HostedNumberOrderList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function ucfirst;

class HostedNumbers extends Version
{
    protected $_authorizationDocuments;
    protected $_hostedNumberOrders;

    public function __construct(Domain $domain)
    {
        parent::__construct($domain);
        $this->version = 'HostedNumbers';
    }

    protected function getAuthorizationDocuments(): AuthorizationDocumentList
    {
        if (!$this->_authorizationDocuments) {
            $this->_authorizationDocuments = new AuthorizationDocumentList($this);
        }
        return $this->_authorizationDocuments;
    }

    protected function getHostedNumberOrders(): HostedNumberOrderList
    {
        if (!$this->_hostedNumberOrders) {
            $this->_hostedNumberOrders = new HostedNumberOrderList($this);
        }
        return $this->_hostedNumberOrders;
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
        return '[Twilio.Preview.HostedNumbers]';
    }
}