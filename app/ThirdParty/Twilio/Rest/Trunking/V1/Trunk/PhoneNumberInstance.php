<?php

namespace Twilio\Rest\Trunking\V1\Trunk;

use DateTime;
use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use function array_key_exists;
use function implode;
use function property_exists;
use function ucfirst;

class PhoneNumberInstance extends InstanceResource
{
    public function __construct(Version $version, array $payload, string $trunkSid, string $sid = null)
    {
        parent::__construct($version);
        $this->properties = ['accountSid' => Values::array_get($payload, 'account_sid'), 'addressRequirements' => Values::array_get($payload, 'address_requirements'), 'apiVersion' => Values::array_get($payload, 'api_version'), 'beta' => Values::array_get($payload, 'beta'), 'capabilities' => Values::array_get($payload, 'capabilities'), 'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')), 'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')), 'friendlyName' => Values::array_get($payload, 'friendly_name'), 'links' => Values::array_get($payload, 'links'), 'phoneNumber' => Values::array_get($payload, 'phone_number'), 'sid' => Values::array_get($payload, 'sid'), 'smsApplicationSid' => Values::array_get($payload, 'sms_application_sid'), 'smsFallbackMethod' => Values::array_get($payload, 'sms_fallback_method'), 'smsFallbackUrl' => Values::array_get($payload, 'sms_fallback_url'), 'smsMethod' => Values::array_get($payload, 'sms_method'), 'smsUrl' => Values::array_get($payload, 'sms_url'), 'statusCallback' => Values::array_get($payload, 'status_callback'), 'statusCallbackMethod' => Values::array_get($payload, 'status_callback_method'), 'trunkSid' => Values::array_get($payload, 'trunk_sid'), 'url' => Values::array_get($payload, 'url'), 'voiceApplicationSid' => Values::array_get($payload, 'voice_application_sid'), 'voiceCallerIdLookup' => Values::array_get($payload, 'voice_caller_id_lookup'), 'voiceFallbackMethod' => Values::array_get($payload, 'voice_fallback_method'), 'voiceFallbackUrl' => Values::array_get($payload, 'voice_fallback_url'), 'voiceMethod' => Values::array_get($payload, 'voice_method'), 'voiceUrl' => Values::array_get($payload, 'voice_url'),];
        $this->solution = ['trunkSid' => $trunkSid, 'sid' => $sid ?: $this->properties['sid'],];
    }

    protected function proxy(): PhoneNumberContext
    {
        if (!$this->context) {
            $this->context = new PhoneNumberContext($this->version, $this->solution['trunkSid'], $this->solution['sid']);
        }
        return $this->context;
    }

    public function fetch(): PhoneNumberInstance
    {
        return $this->proxy()->fetch();
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
        return '[Twilio.Trunking.V1.PhoneNumberInstance ' . implode(' ', $context) . ']';
    }
}