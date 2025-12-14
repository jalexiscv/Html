<?php

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOnContext;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOnList;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;
use function call_user_func_array;
use function implode;
use function method_exists;
use function property_exists;
use function rawurlencode;
use function ucfirst;

class IncomingPhoneNumberContext extends InstanceContext
{
    protected $_assignedAddOns;

    public function __construct(Version $version, $accountSid, $sid)
    {
        parent::__construct($version);
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid,];
        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/IncomingPhoneNumbers/' . rawurlencode($sid) . '.json';
    }

    public function update(array $options = []): IncomingPhoneNumberInstance
    {
        $options = new Values($options);
        $data = Values::of(['AccountSid' => $options['accountSid'], 'ApiVersion' => $options['apiVersion'], 'FriendlyName' => $options['friendlyName'], 'SmsApplicationSid' => $options['smsApplicationSid'], 'SmsFallbackMethod' => $options['smsFallbackMethod'], 'SmsFallbackUrl' => $options['smsFallbackUrl'], 'SmsMethod' => $options['smsMethod'], 'SmsUrl' => $options['smsUrl'], 'StatusCallback' => $options['statusCallback'], 'StatusCallbackMethod' => $options['statusCallbackMethod'], 'VoiceApplicationSid' => $options['voiceApplicationSid'], 'VoiceCallerIdLookup' => Serialize::booleanToString($options['voiceCallerIdLookup']), 'VoiceFallbackMethod' => $options['voiceFallbackMethod'], 'VoiceFallbackUrl' => $options['voiceFallbackUrl'], 'VoiceMethod' => $options['voiceMethod'], 'VoiceUrl' => $options['voiceUrl'], 'EmergencyStatus' => $options['emergencyStatus'], 'EmergencyAddressSid' => $options['emergencyAddressSid'], 'TrunkSid' => $options['trunkSid'], 'VoiceReceiveMode' => $options['voiceReceiveMode'], 'IdentitySid' => $options['identitySid'], 'AddressSid' => $options['addressSid'], 'BundleSid' => $options['bundleSid'],]);
        $payload = $this->version->update('POST', $this->uri, [], $data);
        return new IncomingPhoneNumberInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function fetch(): IncomingPhoneNumberInstance
    {
        $payload = $this->version->fetch('GET', $this->uri);
        return new IncomingPhoneNumberInstance($this->version, $payload, $this->solution['accountSid'], $this->solution['sid']);
    }

    public function delete(): bool
    {
        return $this->version->delete('DELETE', $this->uri);
    }

    protected function getAssignedAddOns(): AssignedAddOnList
    {
        if (!$this->_assignedAddOns) {
            $this->_assignedAddOns = new AssignedAddOnList($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->_assignedAddOns;
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
        return '[Twilio.Api.V2010.IncomingPhoneNumberContext ' . implode(' ', $context) . ']';
    }
}