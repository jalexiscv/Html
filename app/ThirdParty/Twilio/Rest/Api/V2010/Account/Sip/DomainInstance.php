<?php

namespace Twilio\Rest\Api\V2010\Account\Sip;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\AuthTypesList;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\CredentialListMappingList;
use Twilio\Rest\Api\V2010\Account\Sip\Domain\IpAccessControlListMappingList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class DomainInstance extends InstanceResource
{
    protected $_ipAccessControlListMappings;
    protected $_credentialListMappings;
    protected $_auth;

    public function __construct(Version $version, array $payload, string $accountSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'apiVersion' => Values::array_get($payload, 'api_version'), 'authType' => Values::array_get($payload, 'auth_type'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'domainName' => Values::array_get($payload, 'domain_name'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'sid' => Values::array_get($payload, 'sid'), 'uri' => Values::array_get($payload, 'uri'), 'voiceFallbackMethod' => Values::array_get($payload, 'voice_fallback_method'), 'voiceFallbackUrl' => Values::array_get($payload, 'voice_fallback_url'), 'voiceMethod' => Values::array_get($payload, 'voice_method'), 'voiceStatusCallbackMethod' => Values::array_get($payload, 'voice_status_callback_method'), 'voiceStatusCallbackUrl' => Values::array_get($payload, 'voice_status_callback_url'), 'voiceUrl' => Values::array_get($payload, 'voice_url'), 'subresourceUris' => Values::array_get($payload, 'subresource_uris'), 'sipRegistration' => Values::array_get($payload, 'sip_registration'), 'emergencyCallingEnabled' => Values::array_get($payload, 'emergency_calling_enabled'), 'secure' => Values::array_get($payload, 'secure'), 'byocTrunkSid' => Values::array_get($payload, 'byoc_trunk_sid'), 'emergencyCallerSid' => Values::array_get($payload, 'emergency_caller_sid'),];
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    public function fetch(): DomainInstance
    {
        return $this->proxy()->fetch();
    }

    public function update(array $options = []): DomainInstance
    {
        return $this->proxy()->update($options);
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        throw new TwilioException('Unknown property: ' . $name);
    }

    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Api.V2010.DomainInstance ' . implode(' ', $context) . ']';
    }

    protected function proxy(): DomainContext
    {
        if (!$this->context) {
            $this->context = new DomainContext($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    protected function getIpAccessControlListMappings(): IpAccessControlListMappingList
    {
        return $this->proxy()->ipAccessControlListMappings;
    }

    protected function getCredentialListMappings(): CredentialListMappingList
    {
        return $this->proxy()->credentialListMappings;
    }

    protected function getAuth(): AuthTypesList
    {
        return $this->proxy()->auth;
    }
}