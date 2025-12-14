<?php

namespace Twilio\Rest\Api\V2010\Account\Sip;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypesList;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\CredentialListMappingContext;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\CredentialListMappingList;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\IpAccessControlListMappingContext;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\IpAccessControlListMappingList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class DomainContext extends InstanceContext
{
    protected $_ipAccessControlListMappings;
    protected $_credentialListMappings;
    protected $_auth;

    public function __construct(Version $version, $accountSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/SIP/Domains/' . rawurlencode($sid) . '.json';
    }

    public function fetch(): DomainInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new DomainInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function update(array $options = []): DomainInstance
    {
        $options = new Values($options);
        $data = Values::of(['FriendlyName' => $options['friendlyName'], 'VoiceFallbackMethod' => $options['voiceFallbackMethod'], 'VoiceFallbackUrl' => $options['voiceFallbackUrl'], 'VoiceMethod' => $options['voiceMethod'], 'VoiceStatusCallbackMethod' => $options['voiceStatusCallbackMethod'], 'VoiceStatusCallbackUrl' => $options['voiceStatusCallbackUrl'], 'VoiceUrl' => $options['voiceUrl'], 'SipRegistration' => Serialize::booleanToString($options['sipRegistration']), 'DomainName' => $options['domainName'], 'EmergencyCallingEnabled' => Serialize::booleanToString($options['emergencyCallingEnabled']), 'Secure' => Serialize::booleanToString($options['secure']), 'ByocTrunkSid' => $options['byocTrunkSid'], 'EmergencyCallerSid' => $options['emergencyCallerSid'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new DomainInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    public function __get(string $name): ListResource
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
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.DomainContext ' . implode(' ', $context) . ']';
    }

    protected function getIpAccessControlListMappings(): IpAccessControlListMappingList
    {
        if (!$this->_ipAccessControlListMappings) {
            $this->_ipAccessControlListMappings = new IpAccessControlListMappingList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_ipAccessControlListMappings;
    }

    protected function getCredentialListMappings(): CredentialListMappingList
    {
        if (!$this->_credentialListMappings) {
            $this->_credentialListMappings = new CredentialListMappingList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_credentialListMappings;
    }

    protected function getAuth(): AuthTypesList
    {
        if (!$this->_auth) {
            $this->_auth = new AuthTypesList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_auth;
    }
}