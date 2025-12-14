<?php

namespace Twilio\Rest\Api\V2010\Account;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOnList;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class IncomingPhoneNumberInstance extends InstanceResource
{
    protected $_assignedAddOns;

    public function __construct(Version $version, array $payload, string $accountSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'addressSid' => Values::array_get($payload, 'address_sid'), 'addressRequirements' => Values::array_get($payload, 'address_requirements'), 'apiVersion' => Values::array_get($payload, 'api_version'), 'beta' => Values::array_get($payload, 'beta'), 'capabilities' => Values::array_get($payload, 'capabilities'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'identitySid' => Values::array_get($payload, 'identity_sid'), 'phoneNumber' => Values::array_get($payload, 'phone_number'), 'origin' => Values::array_get($payload, 'origin'), 'sid' => Values::array_get($payload, 'sid'), 'smsApplicationSid' => Values::array_get($payload, 'sms_application_sid'), 'smsFallbackMethod' => Values::array_get($payload, 'sms_fallback_method'), 'smsFallbackUrl' => Values::array_get($payload, 'sms_fallback_url'), 'smsMethod' => Values::array_get($payload, 'sms_method'), 'smsUrl' => Values::array_get($payload, 'sms_url'), 'statusCallback' => Values::array_get($payload, 'status_callback'), 'statusCallbackMethod' => Values::array_get($payload, 'status_callback_method'), 'trunkSid' => Values::array_get($payload, 'trunk_sid'), 'uri' => Values::array_get($payload, 'uri'), 'voiceReceiveMode' => Values::array_get($payload, 'voice_receive_mode'), 'voiceApplicationSid' => Values::array_get($payload, 'voice_application_sid'), 'voiceCallerIdLookup' => Values::array_get($payload, 'voice_caller_id_lookup'), 'voiceFallbackMethod' => Values::array_get($payload, 'voice_fallback_method'), 'voiceFallbackUrl' => Values::array_get($payload, 'voice_fallback_url'), 'voiceMethod' => Values::array_get($payload, 'voice_method'), 'voiceUrl' => Values::array_get($payload, 'voice_url'), 'emergencyStatus' => Values::array_get($payload, 'emergency_status'), 'emergencyAddressSid' => Values::array_get($payload, 'emergency_address_sid'), 'bundleSid' => Values::array_get($payload, 'bundle_sid'), 'status' => Values::array_get($payload, 'status'),];
        $this->solution = ['accountSid' => $accountSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): IncomingPhoneNumberContext
    {
        if (!$this->context) {
            $this->context = new IncomingPhoneNumberContext($this->version, $this->solution['accountSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function update(array $options = []): IncomingPhoneNumberInstance
    {
        return $this->proxy()->update($options);
    }

    public function fetch(): IncomingPhoneNumberInstance
    {
        return $this->proxy()->fetch();
    }

    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    protected function getAssignedAddOns(): AssignedAddOnList
    {
        return $this->proxy()->assignedAddOns;
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
        return '[Twilio.Api.V2010.IncomingPhoneNumberInstance ' . implode(' ', $context) . ']';
    }
}