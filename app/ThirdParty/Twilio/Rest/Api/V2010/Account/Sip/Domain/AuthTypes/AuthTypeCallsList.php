<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypes;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypes\AuthTypeCalls\AuthCallsCredentialListMappingContext;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypes\AuthTypeCalls\AuthCallsCredentialListMappingList;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypes\AuthTypeCalls\AuthCallsIpAccessControlListMappingContext;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypes\AuthTypeCalls\AuthCallsIpAccessControlListMappingList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function property_exists;
use function ucfirst;

class AuthTypeCallsList extends ListResource
{
    protected $_credentialListMappings = null;
    protected $_ipAccessControlListMappings = null;

    public function __construct(Version $version, string $accountSid, string $domainSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'domainSid' => $domainSid,];
    }

    protected function getCredentialListMappings(): AuthCallsCredentialListMappingList
    {
        if (!$this->_credentialListMappings) {
            $this->_credentialListMappings = new AuthCallsCredentialListMappingList($this->version, $this->solution['accountSid'], $this->solution['domainSid']);
        }
        return $this->_credentialListMappings;
    }

    protected function getIpAccessControlListMappings(): AuthCallsIpAccessControlListMappingList
    {
        if (!$this->_ipAccessControlListMappings) {
            $this->_ipAccessControlListMappings = new AuthCallsIpAccessControlListMappingList($this->version, $this->solution['accountSid'], $this->solution['domainSid']);
        }
        return $this->_ipAccessControlListMappings;
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
        return '[Twilio.Api.V2010.AuthTypeCallsList]';
    }
}