<?php

namespace Twilio\Rest\Api\V2010\Account\Address;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function property_exists;
use function ucfirst;

class DependentPhoneNumberInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $accountSid, string $addressSid)
    {
        parent::__construct($version);
        $this->properties = ['sid' => Values::array_get($payload, 'sid'), 'accountSid' => Values::array_get($payload, 'account_sid'), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'phoneNumber' => Values::array_get($payload, 'phone_number'), 'voiceUrl' => Values::array_get($payload, 'voice_url'), 'voiceMethod' => Values::array_get($payload, 'voice_method'), 'voiceFallbackMethod' => Values::array_get($payload, 'voice_fallback_method'), 'voiceFallbackUrl' => Values::array_get($payload, 'voice_fallback_url'), 'voiceCallerIdLookup' => Values::array_get($payload, 'voice_caller_id_lookup'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'smsFallbackMethod' => Values::array_get($payload, 'sms_fallback_method'), 'smsFallbackUrl' => Values::array_get($payload, 'sms_fallback_url'), 'smsMethod' => Values::array_get($payload, 'sms_method'), 'smsUrl' => Values::array_get($payload, 'sms_url'), 'addressRequirements' => Values::array_get($payload, 'address_requirements'), 'capabilities' => Values::array_get($payload, 'capabilities'), 'statusCallback' => Values::array_get($payload, 'status_callback'), 'statusCallbackMethod' => Values::array_get($payload, 'status_callback_method'), 'apiVersion' => Values::array_get($payload, 'api_version'), 'smsApplicationSid' => Values::array_get($payload, 'sms_application_sid'), 'voiceApplicationSid' => Values::array_get($payload, 'voice_application_sid'), 'trunkSid' => Values::array_get($payload, 'trunk_sid'), 'emergencyStatus' => Values::array_get($payload, 'emergency_status'), 'emergencyAddressSid' => Values::array_get($payload, 'emergency_address_sid'), 'uri' => Values::array_get($payload, 'uri'),];
        $this->solution = ['accountSid' => $accountSid, 'addressSid' => $addressSid,];
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
        return '[Twilio.Api.V2010.DependentPhoneNumberInstance]';
    }
}