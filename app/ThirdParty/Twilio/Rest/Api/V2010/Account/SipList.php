<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Api\V2010\Account\Sip\CredentialListContext;
use Twilio\Rest\Api\V2010\Account\Sip\CredentialListList;
use Twilio\Rest\Api\V2010\Account\Sip\DomainContext;
use Twilio\Rest\Api\V2010\Account\Sip\DomainList;
use Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlListContext;
use Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlListList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function property_exists;
use function ucfirst;

class SipList extends ListResource
{
    protected $_domains = null;
    protected $_ipAccessControlLists = null;
    protected $_credentialLists = null;

    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid,];
    }

    protected function getDomains(): DomainList
    {
        if (!$this->_domains) {
            $this->_domains = new DomainList($this->version, $this->solution['accountSid']);
        }
        return $this->_domains;
    }

    protected function getIpAccessControlLists(): IpAccessControlListList
    {
        if (!$this->_ipAccessControlLists) {
            $this->_ipAccessControlLists = new IpAccessControlListList($this->version, $this->solution['accountSid']);
        }
        return $this->_ipAccessControlLists;
    }

    protected function getCredentialLists(): CredentialListList
    {
        if (!$this->_credentialLists) {
            $this->_credentialLists = new CredentialListList($this->version, $this->solution['accountSid']);
        }
        return $this->_credentialLists;
    }

    public function __get(string $name)
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
        return '[Twilio.Api.V2010.SipList]';
    }
}