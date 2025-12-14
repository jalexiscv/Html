<?php

namespace Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypes;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypes\AuthTypeRegistrations\AuthRegistrationsCredentialListMappingContext;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypes\AuthTypeRegistrations\AuthRegistrationsCredentialListMappingList;
use Twilio\Version;
use function call_user_func_array;
use function method_exists;
use function property_exists;
use function ucfirst;

class AuthTypeRegistrationsList extends ListResource
{
    protected $_credentialListMappings = null;

    public function __construct(Version $version, string $accountSid, string $domainSid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'domainSid' => $domainSid,];
    }

    protected function getCredentialListMappings(): AuthRegistrationsCredentialListMappingList
    {
        if (!$this->_credentialListMappings) {
            $this->_credentialListMappings = new AuthRegistrationsCredentialListMappingList($this->version, $this->solution['accountSid'], $this->solution['domainSid']);
        }
        return $this->_credentialListMappings;
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
        return '[Twilio.Api.V2010.AuthTypeRegistrationsList]';
    }
}